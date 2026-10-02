<?php

namespace Database\Seeders;

use App\Models\TahunLulus;
use Illuminate\Database\Seeder;

class TahunLulusSeeder extends Seeder
{
    /**
     * Seed tahun lulus contoh (5 tahun terakhir).
     */
    public function run(): void
    {
        $currentYear = (int) date('Y');

        for ($year = $currentYear - 5; $year <= $currentYear; $year++) {
            TahunLulus::firstOrCreate(['tahun' => $year]);
        }
    }
}
