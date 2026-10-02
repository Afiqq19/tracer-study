<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AlumniTemplateExport implements FromArray, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{

    public function headings(): array
    {
        return [
            'NISN (Wajib 10 Digit)',
            'Nama Lengkap (Wajib)'
        ];
    }

    public function array(): array
    {
        return [
            ['2305102008', 'Mhd. Syafiq Syahmi']
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        // Set column alignment and font color explicitly for Dark Mode compatibility
        $sheet->getStyle('A:B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A:B')->getFont()->getColor()->setARGB('FF000000'); // Explicitly black text
        $sheet->getStyle('A:B')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); // Explicitly white background

        return [
            // Styling Header Kolom (Baris ke-1)
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 
                    'color' => ['argb' => 'FF4F46E5'] // Indigo
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }

    public function title(): string
    {
        return 'Template Import Alumni';
    }
}
