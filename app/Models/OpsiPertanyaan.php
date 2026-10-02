<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpsiPertanyaan extends Model
{
    protected $table = 'opsi_pertanyaan';

    public $timestamps = false;

    protected $fillable = [
        'pertanyaan_id',
        'teks',
        'urutan',
    ];

    // ========== RELASI ==========

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
}
