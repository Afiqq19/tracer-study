<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Jurusan;
use App\Models\TahunLulus;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\AlumniImport;
// use App\Exports\AlumniExport;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Alumni::with(['jurusan', 'tahunLulus', 'user']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nisn', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        // Filter Tahun Lulus
        if ($request->has('tahun_lulus_id') && $request->tahun_lulus_id != '') {
            $query->where('tahun_lulus_id', $request->tahun_lulus_id);
        }

        // Filter Jurusan
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        $alumni = $query->latest()->paginate(15)->withQueryString();
        
        $tahunLulus = TahunLulus::orderBy('tahun', 'desc')->get();
        $jurusan = Jurusan::all();

        return view('admin.alumni.index', compact('alumni', 'tahunLulus', 'jurusan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunLulus = TahunLulus::orderBy('tahun', 'desc')->get();
        $jurusan = Jurusan::all();
        
        return view('admin.alumni.create', compact('tahunLulus', 'jurusan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|digits:10|unique:alumni,nisn',
            'nama' => 'required|string|max:255',
            'tahun_lulus_id' => 'required|exists:tahun_lulus,id',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $validated['status_registrasi'] = 'belum_daftar';

        Alumni::create($validated);
        
        LogService::catat('tambah_alumni', "Menambahkan data alumni (Manual): {$validated['nisn']} - {$validated['nama']}");

        return redirect()->route('admin.alumni.index')->with('success', 'Data alumni berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumni $alumni)
    {
        $tahunLulus = TahunLulus::orderBy('tahun', 'desc')->get();
        $jurusan = Jurusan::all();
        
        return view('admin.alumni.edit', compact('alumni', 'tahunLulus', 'jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'nisn' => ['required', 'digits:10', Rule::unique('alumni')->ignore($alumni->id)],
            'nama' => 'required|string|max:255',
            'tahun_lulus_id' => 'required|exists:tahun_lulus,id',
            'jurusan_id' => 'required|exists:jurusan,id',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kabupaten_kota' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
        ]);

        $alumni->update($validated);
        
        LogService::catat('ubah_alumni', "Mengubah data alumni: {$alumni->nisn}");

        return redirect()->route('admin.alumni.index')->with('success', 'Data alumni berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumni $alumni)
    {
        $nisn = $alumni->nisn;
        $alumni->delete(); // Soft delete
        
        LogService::catat('hapus_alumni', "Menghapus data alumni: {$nisn}");

        return redirect()->route('admin.alumni.index')->with('success', 'Data alumni berhasil dihapus.');
    }

    // Nanti akan diimplementasikan Excel Import/Export
    public function importForm()
    {
        return view('admin.alumni.import');
    }

    public function importProcess(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\AlumniImport, $request->file('file'));
        
        $berhasil = session('import_berhasil', 0);
        $gagal = session('import_gagal', 0);

        \App\Services\LogService::catat('import_alumni', "Import data alumni dari Excel: $berhasil berhasil, $gagal gagal");

        return redirect()->route('admin.alumni.index')->with('success', "Proses import selesai. $berhasil data berhasil ditambahkan, $gagal data gagal/dilewati (NISN duplikat atau tidak valid).");
    }

    public function export(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AlumniExport($request->tahun_lulus_id, $request->jurusan_id), 'data-alumni.xlsx');
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AlumniTemplateExport, 'template_alumni.xlsx');
    }
}
