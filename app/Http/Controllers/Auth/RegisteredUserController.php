<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $tahunLulus = \App\Models\TahunLulus::orderBy('tahun', 'desc')->get();
        $jurusan = \App\Models\Jurusan::all();
        
        return view('auth.register', compact('tahunLulus', 'jurusan'));
    }

    public function checkNisn(Request $request)
    {
        $request->validate([
            'nisn' => 'required|digits:10'
        ]);

        $alumni = \App\Models\Alumni::where('nisn', $request->nisn)->first();

        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'NISN tidak terdaftar di database. Silakan hubungi Admin.'
            ]);
        }

        if ($alumni->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'NISN sudah memiliki akun terdaftar.'
            ]);
        }

        return response()->json([
            'success' => true,
            'nama' => $alumni->nama,
            'message' => 'NISN tersedia!'
        ]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email'
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan / terdaftar. Silakan gunakan email lain atau login.'
        ]);

        $otp = rand(100000, 999999);
        \Illuminate\Support\Facades\Cache::put('otp_' . $request->email, $otp, now()->addMinutes(10));

        // For local development, log the OTP so it's easy to test without real SMTP
        \Illuminate\Support\Facades\Log::info("OTP untuk {$request->email} adalah: {$otp}");
        
        // Simulasikan pengiriman email (jika SMTP belum disetup, fallback ke log)
        try {
            \Illuminate\Support\Facades\Mail::raw("Kode OTP Anda adalah: {$otp}. Kode ini berlaku selama 10 menit.", function($msg) use ($request) {
                $msg->to($request->email)->subject('Kode OTP Verifikasi Registrasi Alumni');
            });
        } catch (\Exception $e) {
            // Abaikan error email jika SMTP belum disetup
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP telah dikirim ke email Anda.'
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nisn' => ['required', 'digits:10'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'tahun_lulus_id' => ['required', 'exists:tahun_lulus,id'],
            'jurusan_id' => ['required', 'exists:jurusan,id'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'agama' => ['required', 'string', 'max:50'],
            'no_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'provinsi' => ['required', 'string', 'max:255'],
            'kabupaten_kota' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Alamat email ini sudah terdaftar. Silakan gunakan email lain atau login.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
        ]);

        // Cek apakah NISN ada di tabel alumni
        $alumni = \App\Models\Alumni::where('nisn', $request->nisn)->first();

        if (!$alumni) {
            throw ValidationException::withMessages([
                'nisn' => 'NISN tidak terdaftar di database sekolah. Hubungi admin.',
            ]);
        }

        // Cek apakah alumni ini sudah memiliki user
        if ($alumni->user_id) {
            throw ValidationException::withMessages([
                'nisn' => 'NISN ini sudah memiliki akun yang terdaftar.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni', // Default role untuk registrasi
        ]);

        // Link User to Alumni dan lengkapi data diri, lalu ubah status
        $alumni->update([
            'user_id' => $user->id,
            'tahun_lulus_id' => $request->tahun_lulus_id,
            'jurusan_id' => $request->jurusan_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'status_registrasi' => 'menunggu_verifikasi'
        ]);

        \App\Services\LogService::catat('registrasi_alumni', "Alumni mendaftar: {$alumni->nisn} - {$user->email}", $user->id);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
