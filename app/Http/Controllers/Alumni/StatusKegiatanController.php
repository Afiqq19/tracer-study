<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\StatusKegiatan;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusKegiatanController extends Controller
{
    /**
     * Tampilkan daftar status kegiatan alumni (riwayat).
     */
    public function index()
    {
        return redirect()->route('alumni.data-diri.index', ['tab' => 'status']);
    }

    /**
     * Tampilkan form tambah status kegiatan.
     */
    public function create()
    {
        return redirect()->route('alumni.data-diri.index', ['tab' => 'status']);
    }

    /**
     * Simpan status kegiatan baru.
     */
    public function store(Request $request)
    {
        $alumni = Auth::user()->alumni;

        $validated = $request->validate([
            'jenis' => 'required|in:kuliah,bekerja,wirausaha,belum_bekerja',
            'nama_instansi' => 'required_unless:jenis,belum_bekerja|string|max:255|nullable',
            'bidang_atau_jabatan' => 'required_unless:jenis,belum_bekerja|string|max:255|nullable',
            'kota' => 'nullable|string|max:255',
            'tahun_mulai' => 'nullable|integer|digits:4',
            'masa_tunggu_bulan' => 'nullable|integer|min:0|max:120',
            'kesesuaian_bidang' => 'nullable|in:sesuai,kurang_sesuai,tidak_sesuai',
        ]);

        // Nonaktifkan is_terbaru pada status lama
        $alumni->statusKegiatan()->update(['is_terbaru' => false]);
        $validated['is_terbaru'] = true;

        $alumni->statusKegiatan()->create($validated);

        LogService::catat('tambah_status_kegiatan', 'Alumni menambahkan status kegiatan: ' . $validated['jenis'], Auth::id());

        return redirect()->route('alumni.data-diri.index', ['tab' => 'status'])->with('success', 'Status kegiatan berhasil ditambahkan.');
    }

    /**
     * Hapus status kegiatan.
     */
    public function destroy($id)
    {
        $alumni = Auth::user()->alumni;
        $status = $alumni->statusKegiatan()->findOrFail($id);
        
        $status->delete();

        LogService::catat('hapus_status_kegiatan', 'Alumni menghapus riwayat status kegiatan', Auth::id());

        return redirect()->route('alumni.data-diri.index', ['tab' => 'status'])->with('success', 'Status kegiatan berhasil dihapus.');
    }
}
