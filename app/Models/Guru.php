<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'no_hp',
        'email',
        'alamat',
        'foto',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Relasi User Login
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Relasi Wali Kelas
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    /**
     * Relasi Penugasan Mengajar
     */
    public function guruMengajars()
    {
        return $this->hasMany(GuruMengajar::class);
    }
}
