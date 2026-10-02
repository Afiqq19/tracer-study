<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatistikService;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     */
    public function index()
    {
        $ringkasan = StatistikService::ringkasanDashboard();
        $statusAlumni = StatistikService::statusAlumni();
        $alumniPerTahun = StatistikService::alumniPerTahunLulus();
        
        // Menghitung sudah diverifikasi
        $ringkasan['sudah_diverifikasi'] = \App\Models\Alumni::where('status_registrasi', 'disetujui')->count();

        return view('admin.dashboard', compact('ringkasan', 'statusAlumni', 'alumniPerTahun'));
    }
}
