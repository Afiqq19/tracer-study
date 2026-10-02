<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Seed jurusan (kompetensi keahlian) contoh SMK.
     */
    public function run(): void
    {
        $jurusan = [
            ['kode' => 'TKJ', 'nama' => 'Teknik Komputer dan Jaringan'],
            ['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak'],
            ['kode' => 'AKL', 'nama' => 'Akuntansi dan Keuangan Lembaga'],
            ['kode' => 'OTKP', 'nama' => 'Otomatisasi dan Tata Kelola Perkantoran'],
            ['kode' => 'BDP', 'nama' => 'Bisnis Daring dan Pemasaran'],
            ['kode' => 'TKR', 'nama' => 'Teknik Kendaraan Ringan'],
        ];

        foreach ($jurusan as $j) {
            Jurusan::create($j);
        }
    }
}
