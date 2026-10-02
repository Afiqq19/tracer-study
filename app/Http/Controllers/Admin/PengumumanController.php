<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->paginate(10);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $validated['penulis_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['judul']) . '-' . time();
        
        if ($request->has('is_published')) {
            $validated['published_at'] = now();
        }

        $pengumuman = Pengumuman::create($validated);

        LogService::catat('tambah_pengumuman', "Membuat pengumuman: {$pengumuman->judul}");

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'is_published' => 'boolean',
        ]);

        if ($request->has('is_published') && !$pengumuman->is_published) {
            $validated['published_at'] = now();
        } elseif (!$request->has('is_published')) {
            $validated['published_at'] = null;
        }

        $pengumuman->update($validated);

        LogService::catat('ubah_pengumuman', "Mengubah pengumuman: {$pengumuman->judul}");

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $judul = $pengumuman->judul;
        $pengumuman->delete();

        LogService::catat('hapus_pengumuman', "Menghapus pengumuman: {$judul}");

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
