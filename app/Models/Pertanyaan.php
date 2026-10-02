<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';

    protected $fillable = [
        'kuesioner_id',
        'teks',
        'tipe',
        'wajib',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'wajib' => 'boolean',
        ];
    }

    // ========== RELASI ==========

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class);
    }

    public function opsi()
    {
        return $this->hasMany(OpsiPertanyaan::class)->orderBy('urutan');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}
