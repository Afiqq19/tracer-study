<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\StatusKegiatan;
use App\Models\PengisianKuesioner;
use Illuminate\Support\Facades\DB;

class StatistikService
{
    /**
     * Ringkasan untuk dashboard admin.
     */
    public static function ringkasanDashboard(): array
    {
        return [
            'total_alumni' => Alumni::count(),
            'sudah_mengisi' => PengisianKuesioner::distinct('alumni_id')->count('alumni_id'),
            'belum_mengisi' => Alumni::where('status_registrasi', 'disetujui')
                ->whereDoesntHave('pengisianKuesioner')
                ->count(),
            'menunggu_verifikasi' => Alumni::where('status_registrasi', 'menunggu_verifikasi')->count(),
        ];
    }

    /**
     * Statistik status kegiatan alumni (kuliah, bekerja, wirausaha, belum bekerja).
     */
    public static function statusAlumni(?int $tahunLulusId = null, ?int $jurusanId = null): array
    {
        $query = StatusKegiatan::where('is_terbaru', true)
            ->join('alumni', 'status_kegiatan.alumni_id', '=', 'alumni.id');

        if ($tahunLulusId) {
            $query->where('alumni.tahun_lulus_id', $tahunLulusId);
        }
        if ($jurusanId) {
            $query->where('alumni.jurusan_id', $jurusanId);
        }

        return $query->select('status_kegiatan.jenis', DB::raw('count(*) as total'))
            ->groupBy('status_kegiatan.jenis')
            ->pluck('total', 'jenis')
            ->toArray();
    }

    /**
     * Statistik masa tunggu kerja.
     */
    public static function masaTungguKerja(?int $tahunLulusId = null, ?int $jurusanId = null): array
    {
        $query = StatusKegiatan::where('is_terbaru', true)
            ->whereIn('jenis', ['bekerja', 'wirausaha'])
            ->whereNotNull('masa_tunggu_bulan')
            ->join('alumni', 'status_kegiatan.alumni_id', '=', 'alumni.id');

        if ($tahunLulusId) {
            $query->where('alumni.tahun_lulus_id', $tahunLulusId);
        }
        if ($jurusanId) {
            $query->where('alumni.jurusan_id', $jurusanId);
        }

        $data = $query->select('status_kegiatan.masa_tunggu_bulan')->get();

        $ranges = [
            '0-3 bulan' => 0,
            '4-6 bulan' => 0,
            '7-12 bulan' => 0,
            '> 12 bulan' => 0,
        ];

        foreach ($data as $item) {
            $bulan = $item->masa_tunggu_bulan;
            if ($bulan <= 3) $ranges['0-3 bulan']++;
            elseif ($bulan <= 6) $ranges['4-6 bulan']++;
            elseif ($bulan <= 12) $ranges['7-12 bulan']++;
            else $ranges['> 12 bulan']++;
        }

        return $ranges;
    }

    /**
     * Statistik kesesuaian bidang kerja dengan jurusan.
     */
    public static function kesesuaianBidang(?int $tahunLulusId = null, ?int $jurusanId = null): array
    {
        $query = StatusKegiatan::where('is_terbaru', true)
            ->whereIn('jenis', ['bekerja', 'wirausaha'])
            ->whereNotNull('kesesuaian_bidang')
            ->join('alumni', 'status_kegiatan.alumni_id', '=', 'alumni.id');

        if ($tahunLulusId) {
            $query->where('alumni.tahun_lulus_id', $tahunLulusId);
        }
        if ($jurusanId) {
            $query->where('alumni.jurusan_id', $jurusanId);
        }

        return $query->select('status_kegiatan.kesesuaian_bidang', DB::raw('count(*) as total'))
            ->groupBy('status_kegiatan.kesesuaian_bidang')
            ->pluck('total', 'kesesuaian_bidang')
            ->toArray();
    }

    /**
     * Keterserapan lulusan per jurusan.
     */
    public static function keterserapanPerJurusan(?int $tahunLulusId = null): array
    {
        $query = DB::table('alumni')
            ->join('jurusan', 'alumni.jurusan_id', '=', 'jurusan.id')
            ->leftJoin('status_kegiatan', function ($join) {
                $join->on('alumni.id', '=', 'status_kegiatan.alumni_id')
                    ->where('status_kegiatan.is_terbaru', true);
            })
            ->whereNull('alumni.deleted_at');

        if ($tahunLulusId) {
            $query->where('alumni.tahun_lulus_id', $tahunLulusId);
        }

        return $query->select(
            'jurusan.kode',
            'jurusan.nama',
            DB::raw('COUNT(DISTINCT alumni.id) as total_alumni'),
            DB::raw('COUNT(DISTINCT CASE WHEN status_kegiatan.jenis IN ("bekerja","wirausaha","kuliah") THEN alumni.id END) as terserap'),
            DB::raw('COUNT(DISTINCT CASE WHEN status_kegiatan.jenis = "belum_bekerja" OR status_kegiatan.id IS NULL THEN alumni.id END) as belum_terserap')
        )
            ->groupBy('jurusan.id', 'jurusan.kode', 'jurusan.nama')
            ->get()
            ->toArray();
    }

    /**
     * Jumlah alumni per tahun lulus.
     */
    public static function alumniPerTahunLulus(?int $jurusanId = null): array
    {
        $query = Alumni::join('tahun_lulus', 'alumni.tahun_lulus_id', '=', 'tahun_lulus.id')
            ->whereNull('alumni.deleted_at');

        if ($jurusanId) {
            $query->where('alumni.jurusan_id', $jurusanId);
        }

        return $query->select('tahun_lulus.tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun_lulus.tahun')
            ->orderBy('tahun_lulus.tahun')
            ->pluck('total', 'tahun')
            ->toArray();
    }
}
