<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    protected $table = 'kuesioner';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    // ========== RELASI ==========

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class)->orderBy('urutan');
    }

    public function pengisian()
    {
        return $this->hasMany(PengisianKuesioner::class);
    }

    // ========== HELPERS ==========

    /**
     * Cek apakah kuesioner sedang aktif.
     */
    public function isAktif(): bool
    {
        return $this->status === 'aktif'
            && $this->tanggal_mulai <= now()
            && $this->tanggal_selesai >= now();
    }
}
