<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'nik',
        'no_hp',
        'email',
        'foto',
        'kelas',
        'rombel',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'tanggal_lahir' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /**
     * Semua riwayat kehadiran siswa
     */
    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getNamaLengkapAttribute()
    {
        return $this->nama;
    }

    /*
    |--------------------------------------------------------------------------
    | STATISTIK KEHADIRAN
    |--------------------------------------------------------------------------
    */

    public function totalHadir()
    {
        return $this->kehadirans()
            ->where('status', 'Hadir')
            ->count();
    }

    public function totalIzin()
    {
        return $this->kehadirans()
            ->where('status', 'Izin')
            ->count();
    }

    public function totalSakit()
    {
        return $this->kehadirans()
            ->where('status', 'Sakit')
            ->count();
    }

    public function totalAlfa()
    {
        return $this->kehadirans()
            ->where('status', 'Alfa')
            ->count();
    }

    public function totalTerlambat()
    {
        return $this->kehadirans()
            ->where('status', 'Terlambat')
            ->count();
    }

    public function totalMembolos()
    {
        return $this->kehadirans()
            ->where('status', 'Membolos')
            ->count();
    }
}