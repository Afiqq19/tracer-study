<?php

namespace App\Exports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AlumniExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    use Exportable;

    public function __construct(
        public ?int $tahunLulusId = null,
        public ?int $jurusanId = null
    ) {}

    public function query()
    {
        $query = Alumni::query()->with(['tahunLulus', 'jurusan', 'user']);
        
        if ($this->tahunLulusId) {
            $query->where('tahun_lulus_id', $this->tahunLulusId);
        }
        
        if ($this->jurusanId) {
            $query->where('jurusan_id', $this->jurusanId);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'NISN',
            'Nama Lengkap',
            'Tahun Lulus',
            'Jurusan',
            'Jenis Kelamin',
            'Status Registrasi',
            'No HP',
            'Email',
            'Alamat'
        ];
    }

    public function map($alumni): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $alumni->nisn,
            $alumni->nama,
            $alumni->tahunLulus ? $alumni->tahunLulus->tahun : '-',
            $alumni->jurusan ? $alumni->jurusan->nama : '-',
            $alumni->jenis_kelamin ?? '-',
            str_replace('_', ' ', strtoupper($alumni->status_registrasi)),
            $alumni->no_hp ?? '-',
            $alumni->user ? $alumni->user->email : '-',
            $alumni->alamat ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
