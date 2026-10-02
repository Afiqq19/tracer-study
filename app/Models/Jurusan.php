<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = [
        'kode',
        'nama',
    ];

    // ========== RELASI ==========

    /**
     * Relasi ke alumni yang ada di jurusan ini.
     */
    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }
}
