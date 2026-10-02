<?php

namespace App\Imports;

use App\Models\Alumni;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Services\LogService;
use Illuminate\Support\Facades\Log;

class AlumniImport implements ToCollection, WithStartRow
{
    public function collection(Collection $rows): void
    {
        $berhasil = 0;
        $gagal = 0;
        $listGagal = [];

        foreach ($rows as $row) {
            // Index 0: NISN, Index 1: Nama
            $nisn = trim($row[0] ?? '');
            $nama = trim($row[1] ?? '');

            // Skip jika kosong
            if (empty($nisn) || empty($nama)) {
                continue;
            }

            // Skip jika NISN kurang/lebih dari 10 digit
            if (strlen($nisn) != 10 || !is_numeric($nisn)) {
                $gagal++;
                $listGagal[] = [
                    'nisn' => $nisn,
                    'nama' => $nama,
                    'alasan' => 'Format NISN salah (harus 10 angka)'
                ];
                continue;
            }

            // Cek apakah NISN sudah ada
            $exists = Alumni::where('nisn', $nisn)->exists();
            if ($exists) {
                $gagal++;
                $listGagal[] = [
                    'nisn' => $nisn,
                    'nama' => $nama,
                    'alasan' => 'NISN sudah terdaftar'
                ];
                continue;
            }

            // Buat record baru
            Alumni::create([
                'nisn' => $nisn,
                'nama' => $nama,
                'status_registrasi' => 'belum_daftar'
            ]);
            $berhasil++;
        }

        // Simpan info ke session untuk ditampilkan di view
        session()->flash('import_berhasil', $berhasil);
        session()->flash('import_gagal', $gagal);
        session()->flash('import_gagal_list', $listGagal);
    }

    public function startRow(): int
    {
        // Baris 1: Header
        // Baris 2: Data mulai
        return 2;
    }
}
