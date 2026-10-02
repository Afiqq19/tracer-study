<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use App\Models\Pertanyaan;
use App\Models\OpsiPertanyaan;
use App\Services\LogService;
use Illuminate\Http\Request;

class KuesionerController extends Controller
{
    public function index()
    {
        $kuesioner = Kuesioner::withCount('pertanyaan')->latest()->paginate(10);
        return view('admin.kuesioner.index', compact('kuesioner'));
    }

    public function create()
    {
        return view('admin.kuesioner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        $kuesioner = Kuesioner::create($validated);
        
        LogService::catat('tambah_kuesioner', "Menambahkan kuesioner baru: {$kuesioner->judul}");

        return redirect()->route('admin.kuesioner.show', $kuesioner->id)->with('success', 'Kuesioner berhasil dibuat. Silakan tambahkan pertanyaan.');
    }

    public function show(Kuesioner $kuesioner)
    {
        $kuesioner->load('pertanyaan.opsi');
        return view('admin.kuesioner.show', compact('kuesioner'));
    }

    public function edit(Kuesioner $kuesioner)
    {
        return view('admin.kuesioner.edit', compact('kuesioner'));
    }

    public function update(Request $request, Kuesioner $kuesioner)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        $kuesioner->update($validated);

        LogService::catat('ubah_kuesioner', "Mengubah data kuesioner: {$kuesioner->judul}");

        return redirect()->route('admin.kuesioner.index')->with('success', 'Kuesioner berhasil diperbarui.');
    }

    public function destroy(Kuesioner $kuesioner)
    {
        $judul = $kuesioner->judul;
        $kuesioner->delete();
        
        LogService::catat('hapus_kuesioner', "Menghapus kuesioner: {$judul}");

        return redirect()->route('admin.kuesioner.index')->with('success', 'Kuesioner berhasil dihapus.');
    }

    // -- Pertanyaan --

    public function storePertanyaan(Request $request, Kuesioner $kuesioner)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:pilihan_ganda,isian_singkat,esai,skala',
            'is_required' => 'boolean',
            'opsi' => 'required_if:tipe,pilihan_ganda|array',
            'opsi.*' => 'required_if:tipe,pilihan_ganda|string',
        ]);

        $urutan = $kuesioner->pertanyaan()->max('urutan') + 1;

        $pertanyaan = $kuesioner->pertanyaan()->create([
            'pertanyaan' => $validated['pertanyaan'],
            'tipe' => $validated['tipe'],
            'is_required' => $request->has('is_required'),
            'urutan' => $urutan,
        ]);

        if ($validated['tipe'] === 'pilihan_ganda' && isset($validated['opsi'])) {
            foreach ($validated['opsi'] as $opsiTeks) {
                if (!empty($opsiTeks)) {
                    $pertanyaan->opsi()->create(['opsi' => $opsiTeks]);
                }
            }
        }

        return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function destroyPertanyaan(Pertanyaan $pertanyaan)
    {
        $pertanyaan->delete();
        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
