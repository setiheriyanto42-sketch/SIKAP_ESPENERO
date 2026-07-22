<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruMengajar extends Model
{

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mata_pelajaran_id',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Relasi Tahun Ajaran
     */
    

    /**
     * Relasi Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Relasi Mata Pelajaran
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    /**
     * Relasi Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Relasi Jadwal Mengajar
     */
    public function jadwalMengajars()
    {
        return $this->hasMany(JadwalMengajar::class);
    }
}
