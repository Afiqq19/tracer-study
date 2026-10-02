<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunLulus extends Model
{
    protected $table = 'tahun_lulus';

    protected $fillable = [
        'tahun',
    ];

    // ========== RELASI ==========

    /**
     * Relasi ke alumni yang lulus di tahun ini.
     */
    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }
}
