<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use App\Models\PengisianKuesioner;
use Illuminate\Http\Request;

class HasilKuesionerController extends Controller
{
    public function index()
    {
        $kuesioner = Kuesioner::withCount('pengisian')
            ->latest()
            ->paginate(10);
            
        return view('admin.hasil.index', compact('kuesioner'));
    }

    public function show(Kuesioner $kuesioner)
    {
        $pengisian = PengisianKuesioner::with(['alumni.jurusan', 'alumni.tahunLulus'])
            ->where('kuesioner_id', $kuesioner->id)
            ->latest()
            ->paginate(20);

        return view('admin.hasil.show', compact('kuesioner', 'pengisian'));
    }

    public function detail(Kuesioner $kuesioner, PengisianKuesioner $pengisian)
    {
        $pengisian->load(['alumni', 'jawaban.pertanyaan']);
        
        return view('admin.hasil.detail', compact('kuesioner', 'pengisian'));
    }
}
