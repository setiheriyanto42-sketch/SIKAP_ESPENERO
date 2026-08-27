<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $fillable = [

        'tanggal',

        'guru_id',

        'siswa_id',

        'kelas_id',

        'mata_pelajaran',

        'status',

        'keterangan',

        'jenis_absensi',

        'mapel_id',

        'kegiatan',

        'sesi_mengajar_id',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(
            MataPelajaran::class,
            'mapel_id'
        );
    }

    public function sesiMengajar()
    {
        return $this->belongsTo(
            SesiMengajar::class,
            'sesi_mengajar_id'
        );
    }
}