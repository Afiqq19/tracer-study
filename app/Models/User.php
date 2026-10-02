<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ========== HELPERS ==========

    /**
     * Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah alumni.
     */
    public function isAlumni(): bool
    {
        return $this->role === 'alumni';
    }

    // ========== RELASI ==========

    /**
     * Relasi ke data alumni (one-to-one).
     */
    public function alumni()
    {
        return $this->hasOne(Alumni::class);
    }

    /**
     * Relasi ke kuesioner yang dibuat oleh admin ini.
     */
    public function kuesionerDibuat()
    {
        return $this->hasMany(Kuesioner::class, 'dibuat_oleh');
    }

    /**
     * Relasi ke pengumuman yang dibuat oleh admin ini.
     */
    public function pengumumanDibuat()
    {
        return $this->hasMany(Pengumuman::class, 'dibuat_oleh');
    }

    /**
     * Relasi ke log aktivitas.
     */
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }
}
