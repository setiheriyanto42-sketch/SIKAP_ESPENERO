<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'tingkat',
        'rombel',
        'nama_kelas',
        'guru_id',
        'aktif',
    ];

    /**
     * Relasi Wali Kelas
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Relasi Siswa
     */
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    /**
     * Relasi Penugasan Mengajar
     */
    public function guruMengajars()
    {
        return $this->hasMany(GuruMengajar::class);
    }

    /**
     * Nama lengkap kelas
     */
    public function getNamaLengkapAttribute()
    {
        return "Kelas {$this->tingkat}{$this->rombel}";
    }
}
