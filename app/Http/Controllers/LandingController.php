<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Pengumuman;
use App\Models\PengisianKuesioner;

class LandingController extends Controller
{
    /**
     * Tampilkan landing page.
     */
    public function index()
    {
        // Statistik ringkas
        $totalAlumni = Alumni::count();
        $sudahMengisi = PengisianKuesioner::distinct('alumni_id')->count('alumni_id');
        $persentase = $totalAlumni > 0 ? round(($sudahMengisi / $totalAlumni) * 100, 1) : 0;

        // Pengumuman terbaru
        $pengumuman = Pengumuman::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('landing.index', compact(
            'totalAlumni',
            'sudahMengisi',
            'persentase',
            'pengumuman'
        ));
    }
}
