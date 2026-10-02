<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusKegiatan extends Model
{
    protected $table = 'status_kegiatan';

    protected $fillable = [
        'alumni_id',
        'jenis',
        'nama_instansi',
        'bidang_atau_jabatan',
        'kota',
        'tahun_mulai',
        'masa_tunggu_bulan',
        'kesesuaian_bidang',
        'is_terbaru',
    ];

    protected function casts(): array
    {
        return [
            'is_terbaru' => 'boolean',
        ];
    }

    // ========== RELASI ==========

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
