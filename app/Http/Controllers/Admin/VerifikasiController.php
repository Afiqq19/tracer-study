<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    /**
     * Display a listing of unverified alumni.
     */
    public function index()
    {
        $alumni = Alumni::with(['jurusan', 'tahunLulus', 'user'])
            ->where('status_registrasi', 'menunggu_verifikasi')
            ->latest('updated_at')
            ->paginate(15);

        return view('admin.verifikasi.index', compact('alumni'));
    }

    /**
     * Approve alumni registration.
     */
    public function setujui($id)
    {
        $alumni = Alumni::with('user')->findOrFail($id);
        
        $alumni->update([
            'status_registrasi' => 'disetujui',
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
        ]);

        if ($alumni->user_id) {
            User::where('id', $alumni->user_id)->update(['is_active' => true]);
        }

        // Kirim email notifikasi ke alumni bahwa akunnya telah disetujui
        if ($alumni->user && $alumni->user->email) {
            try {
                $alumni->user->notify(new \App\Notifications\AlumniDisetujuiNotification($alumni));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Gagal mengirim email persetujuan ke {$alumni->user->email}: " . $e->getMessage());
            }
        }

        LogService::catat('verifikasi_disetujui', "Menyetujui pendaftaran alumni: {$alumni->nisn} - {$alumni->nama}");

        return redirect()->route('admin.verifikasi.index')->with('success', "Pendaftaran alumni {$alumni->nama} berhasil disetujui dan email pemberitahuan telah dikirimkan.");
    }

    /**
     * Reject alumni registration.
     */
    public function tolak(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);
        
        $alumni->update([
            'status_registrasi' => 'ditolak'
        ]);

        if ($alumni->user_id) {
            User::where('id', $alumni->user_id)->update(['is_active' => false]);
            // Optional: You could delete the user or leave it as inactive
        }

        LogService::catat('verifikasi_ditolak', "Menolak pendaftaran alumni: {$alumni->nisn} - {$alumni->nama}");

        return redirect()->route('admin.verifikasi.index')->with('warning', "Pendaftaran alumni {$alumni->nama} telah ditolak.");
    }
}
