<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumni extends Model
{
    use SoftDeletes;

    protected $table = 'alumni';

    protected $fillable = [
        'user_id',
        'nisn',
        'nama',
        'tahun_lulus_id',
        'jurusan_id',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'no_hp',
        'alamat',
        'kabupaten_kota',
        'kecamatan',
        'kelurahan',
        'provinsi',
        'instagram',
        'twitter',
        'facebook',
        'tiktok',
        'linkedin',
        'foto',
        'status_registrasi',
        'catatan_penolakan',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    protected $appends = [
        'foto_url',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'diverifikasi_pada' => 'datetime',
        ];
    }

    /**
     * URL Foto Profil Alumni.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->foto)) {
            return \Illuminate\Support\Facades\Storage::url($this->foto);
        }
        return null;
    }

    // ========== RELASI ==========

    /**
     * Relasi ke user (akun login).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke jurusan.
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Relasi ke tahun lulus.
     */
    public function tahunLulus()
    {
        return $this->belongsTo(TahunLulus::class);
    }

    /**
     * Relasi ke admin yang memverifikasi.
     */
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    /**
     * Relasi ke semua status kegiatan.
     */
    public function statusKegiatan()
    {
        return $this->hasMany(StatusKegiatan::class);
    }

    /**
     * Status kegiatan terbaru.
     */
    public function statusKegiatanTerbaru()
    {
        return $this->hasOne(StatusKegiatan::class)->where('is_terbaru', true);
    }

    /**
     * Relasi ke pengisian kuesioner.
     */
    public function pengisianKuesioner()
    {
        return $this->hasMany(PengisianKuesioner::class);
    }

    // ========== HELPERS ==========

    /**
     * Cek apakah alumni sudah disetujui.
     */
    public function sudahDisetujui(): bool
    {
        return $this->status_registrasi === 'disetujui';
    }

    /**
     * Cek apakah alumni sudah mengisi kuesioner tertentu.
     */
    public function sudahMengisiKuesioner(int $kuesionerId): bool
    {
        return $this->pengisianKuesioner()
            ->where('kuesioner_id', $kuesionerId)
            ->exists();
    }
}
