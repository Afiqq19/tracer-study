<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\TahunLulus;
use App\Services\LogService;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->segment(3); // 'jurusan' or 'tahun-lulus'

        if ($type === 'jurusan') {
            $data = Jurusan::latest()->paginate(10);
            return view('admin.master.jurusan.index', compact('data'));
        }

        $data = TahunLulus::orderBy('tahun', 'desc')->paginate(10);
        return view('admin.master.tahun-lulus.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->segment(3);
        
        if ($type === 'jurusan') {
            return view('admin.master.jurusan.create');
        }
        
        return view('admin.master.tahun-lulus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request->segment(3);

        if ($type === 'jurusan') {
            $validated = $request->validate([
                'kode' => 'required|string|max:10|unique:jurusan',
                'nama' => 'required|string|max:255',
            ]);

            Jurusan::create($validated);
            LogService::catat('tambah_jurusan', "Menambahkan jurusan baru: {$validated['kode']}");

            return redirect()->route('admin.master.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
        }

        $validated = $request->validate([
            'tahun' => 'required|digits:4|integer|unique:tahun_lulus',
        ]);

        TahunLulus::create($validated);
        LogService::catat('tambah_tahun_lulus', "Menambahkan tahun lulus baru: {$validated['tahun']}");

        return redirect()->route('admin.master.tahun-lulus.index')->with('success', 'Tahun lulus berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $type = $request->segment(3);

        if ($type === 'jurusan') {
            $jurusan = Jurusan::findOrFail($id);
            return view('admin.master.jurusan.edit', compact('jurusan'));
        }

        $tahunLulus = TahunLulus::findOrFail($id);
        return view('admin.master.tahun-lulus.edit', compact('tahunLulus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $type = $request->segment(3);

        if ($type === 'jurusan') {
            $jurusan = Jurusan::findOrFail($id);
            $validated = $request->validate([
                'kode' => 'required|string|max:10|unique:jurusan,kode,' . $jurusan->id,
                'nama' => 'required|string|max:255',
            ]);

            $jurusan->update($validated);
            LogService::catat('ubah_jurusan', "Mengubah data jurusan: {$jurusan->kode}");

            return redirect()->route('admin.master.jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
        }

        $tahunLulus = TahunLulus::findOrFail($id);
        $validated = $request->validate([
            'tahun' => 'required|digits:4|integer|unique:tahun_lulus,tahun,' . $tahunLulus->id,
        ]);

        $tahunLulus->update($validated);
        LogService::catat('ubah_tahun_lulus', "Mengubah data tahun lulus: {$tahunLulus->tahun}");

        return redirect()->route('admin.master.tahun-lulus.index')->with('success', 'Tahun lulus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $type = $request->segment(3);

        if ($type === 'jurusan') {
            $jurusan = Jurusan::findOrFail($id);
            
            // Check if used by alumni
            if ($jurusan->alumni()->exists()) {
                return redirect()->route('admin.master.jurusan.index')->with('error', 'Jurusan tidak dapat dihapus karena sedang digunakan oleh data alumni.');
            }
            
            $kode = $jurusan->kode;
            $jurusan->delete();
            LogService::catat('hapus_jurusan', "Menghapus jurusan: {$kode}");

            return redirect()->route('admin.master.jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
        }

        $tahunLulus = TahunLulus::findOrFail($id);
        
        // Check if used by alumni
        if ($tahunLulus->alumni()->exists()) {
            return redirect()->route('admin.master.tahun-lulus.index')->with('error', 'Tahun lulus tidak dapat dihapus karena sedang digunakan oleh data alumni.');
        }
        
        $tahun = $tahunLulus->tahun;
        $tahunLulus->delete();
        LogService::catat('hapus_tahun_lulus', "Menghapus tahun lulus: {$tahun}");

        return redirect()->route('admin.master.tahun-lulus.index')->with('success', 'Tahun lulus berhasil dihapus.');
    }
}
