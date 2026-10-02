<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use App\Models\PengisianKuesioner;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KuesionerController extends Controller
{
    /**
     * Daftar kuesioner aktif yang belum diisi dan riwayat pengisian (digabung).
     */
    public function index(Request $request)
    {
        $alumni = Auth::user()->alumni;

        $kuesionerAktif = Kuesioner::where('status', 'aktif')
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->whereDoesntHave('pengisian', function ($q) use ($alumni) {
                $q->where('alumni_id', $alumni->id);
            })
            ->latest()
            ->get();

        $riwayatPengisian = PengisianKuesioner::with(['kuesioner', 'jawaban'])
            ->where('alumni_id', $alumni->id)
            ->latest()
            ->get();

        $activeTab = $request->query('tab', 'aktif');

        return view('alumni.kuesioner.index', compact('kuesionerAktif', 'riwayatPengisian', 'activeTab'));
    }

    /**
     * Menampilkan form isi kuesioner.
     */
    public function show(Kuesioner $kuesioner)
    {
        // Pastikan kuesioner aktif
        if ($kuesioner->status !== 'aktif' || $kuesioner->tanggal_selesai < now() || $kuesioner->tanggal_mulai > now()) {
            return redirect()->route('alumni.kuesioner.index')->with('error', 'Kuesioner ini tidak aktif atau sudah ditutup.');
        }

        $alumni = Auth::user()->alumni;

        // Cek apakah sudah mengisi
        $sudahIsi = PengisianKuesioner::where('alumni_id', $alumni->id)
            ->where('kuesioner_id', $kuesioner->id)
            ->exists();

        if ($sudahIsi) {
            return redirect()->route('alumni.kuesioner.index', ['tab' => 'riwayat'])->with('info', 'Anda sudah mengisi kuesioner ini.');
        }

        $kuesioner->load(['pertanyaan' => function($q) {
            $q->orderBy('urutan');
        }, 'pertanyaan.opsi']);

        return view('alumni.kuesioner.show', compact('kuesioner'));
    }

    /**
     * Menyimpan jawaban kuesioner.
     */
    public function store(Request $request, Kuesioner $kuesioner)
    {
        $alumni = Auth::user()->alumni;

        // Cek kembali status
        if ($kuesioner->status !== 'aktif' || $kuesioner->tanggal_selesai < now()) {
            return redirect()->route('alumni.kuesioner.index')->with('error', 'Kuesioner sudah ditutup.');
        }

        // Validasi jawaban berdasarkan is_required
        $rules = [];
        $messages = [];
        
        foreach ($kuesioner->pertanyaan as $tanya) {
            if ($tanya->is_required) {
                $rules["jawaban.{$tanya->id}"] = 'required';
                $messages["jawaban.{$tanya->id}.required"] = "Pertanyaan '{$tanya->pertanyaan}' wajib diisi.";
            }
        }

        $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            // Buat record pengisian
            $pengisian = PengisianKuesioner::create([
                'alumni_id' => $alumni->id,
                'kuesioner_id' => $kuesioner->id,
            ]);

            // Simpan tiap jawaban
            if ($request->has('jawaban')) {
                foreach ($request->jawaban as $pertanyaanId => $jawaban) {
                    if (!empty($jawaban)) {
                        $pengisian->jawaban()->create([
                            'pertanyaan_id' => $pertanyaanId,
                            'jawaban_teks' => $jawaban,
                        ]);
                    }
                }
            }

            LogService::catat('isi_kuesioner', "Alumni mengisi kuesioner: {$kuesioner->judul}", Auth::id());
            
            DB::commit();
            return redirect()->route('alumni.kuesioner.index', ['tab' => 'riwayat'])->with('success', 'Terima kasih, kuesioner berhasil disubmit.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan kuesioner. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Riwayat kuesioner yang sudah diisi (dialihkan ke tab riwayat).
     */
    public function riwayat()
    {
        return redirect()->route('alumni.kuesioner.index', ['tab' => 'riwayat']);
    }
}
