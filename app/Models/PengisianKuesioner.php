<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengisianKuesioner extends Model
{
    protected $table = 'pengisian_kuesioner';

    protected $fillable = [
        'kuesioner_id',
        'alumni_id',
        'dikirim_pada',
    ];

    protected function casts(): array
    {
        return [
            'dikirim_pada' => 'datetime',
        ];
    }

    // ========== RELASI ==========

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'pengisian_id');
    }
}
