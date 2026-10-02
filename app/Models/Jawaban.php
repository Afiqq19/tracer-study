<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban';

    public $timestamps = false;

    protected $fillable = [
        'pengisian_id',
        'pertanyaan_id',
        'opsi_id',
        'isi_jawaban',
    ];

    // ========== RELASI ==========

    public function pengisian()
    {
        return $this->belongsTo(PengisianKuesioner::class, 'pengisian_id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    public function opsi()
    {
        return $this->belongsTo(OpsiPertanyaan::class, 'opsi_id');
    }
}
