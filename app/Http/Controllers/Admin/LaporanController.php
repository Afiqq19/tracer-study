<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\TahunLulus;
use App\Services\StatistikService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        $tahunLulus = TahunLulus::orderBy('tahun', 'desc')->get();
        return view('admin.laporan.index', compact('jurusan', 'tahunLulus'));
    }

    public function exportPdf(Request $request)
    {
        $query = \App\Models\Alumni::with(['tahunLulus', 'jurusan', 'user', 'pekerjaan', 'pendidikan', 'usaha']);
        
        if ($request->filled('tahun_lulus_id')) {
            $query->where('tahun_lulus_id', $request->tahun_lulus_id);
        }
        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }
        
        $alumni = $query->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf', compact('alumni'))->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_Tracer_Study.pdf');
    }

    public function exportExcel(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AlumniExport($request->tahun_lulus_id, $request->jurusan_id), 
            'Laporan_Tracer_Study.xlsx'
        );
    }
}
