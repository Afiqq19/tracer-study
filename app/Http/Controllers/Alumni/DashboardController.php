<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard alumni.
     */
    public function index()
    {
        $user = Auth::user();
        $alumni = $user->alumni;

        // Cek kelengkapan data
        $dataLengkap = $alumni->jenis_kelamin && $alumni->tempat_lahir && $alumni->tanggal_lahir && $alumni->no_hp && $alumni->alamat;

        // Status kegiatan terbaru
        $statusKegiatan = $alumni->statusKegiatanTerbaru;

        // Jumlah kuesioner aktif yang belum diisi
        $kuesionerAktif = Kuesioner::where('status', 'aktif')
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->whereDoesntHave('pengisian', function ($q) use ($alumni) {
                $q->where('alumni_id', $alumni->id);
            })
            ->count();

        // Pengumuman terbaru
        $pengumuman = Pengumuman::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('alumni.dashboard', compact(
            'alumni',
            'dataLengkap',
            'statusKegiatan',
            'kuesionerAktif',
            'pengumuman'
        ));
    }
}
