<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DataDiriController extends Controller
{
    /**
     * Tampilkan form data diri alumni beserta status kegiatan saat ini.
     */
    public function index(Request $request)
    {
        $alumni = Auth::user()->alumni;
        $statusKegiatan = $alumni ? $alumni->statusKegiatan()->latest()->get() : collect();
        $activeTab = $request->query('tab', 'biodata');

        return view('alumni.data-diri.index', compact('alumni', 'statusKegiatan', 'activeTab'));
    }

    /**
     * Update data diri alumni (termasuk foto profil dan media sosial).
     */
    public function update(Request $request)
    {
        $alumni = Auth::user()->alumni;

        $validated = $request->validate([
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kabupaten_kota' => 'required|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'provinsi' => 'required|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Tangani Hapus Foto jika diminta
        if ($request->boolean('hapus_foto')) {
            if ($alumni->foto && Storage::disk('public')->exists($alumni->foto)) {
                Storage::disk('public')->delete($alumni->foto);
            }
            $validated['foto'] = null;
        }

        // Tangani Upload Foto Baru
        if ($request->hasFile('foto')) {
            if ($alumni->foto && Storage::disk('public')->exists($alumni->foto)) {
                Storage::disk('public')->delete($alumni->foto);
            }
            $path = $request->file('foto')->store('alumni_foto', 'public');
            $validated['foto'] = $path;
        }

        $alumni->update($validated);

        LogService::catat('update_data_diri', 'Alumni memperbarui biodata diri & profil', Auth::id());

        return redirect()->route('alumni.data-diri.index', ['tab' => 'biodata'])
            ->with('success', 'Data diri dan foto profil berhasil disimpan.');
    }
}
