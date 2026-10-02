<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatistikService;

class StatistikController extends Controller
{
    public function index()
    {
        $statusAlumni = StatistikService::statusAlumni();
        $keterserapan = StatistikService::keterserapanPerJurusan();
        $ringkasan = StatistikService::ringkasanDashboard();

        return view('admin.statistik.index', compact('statusAlumni', 'keterserapan', 'ringkasan'));
    }
}
