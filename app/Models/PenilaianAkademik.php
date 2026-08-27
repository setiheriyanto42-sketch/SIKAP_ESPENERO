<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianAkademik extends Model
{
    protected $table = 'penilaian_akademiks';

    protected $fillable = [
        'sesi_mengajar_id',
        'perencanaan_pertemuan_id',
        'jenis',
        'judul',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI SESI MENGAJAR
    |--------------------------------------------------------------------------
    */

    public function sesiMengajar()
    {
        return $this->belongsTo(
            SesiMengajar::class,
            'sesi_mengajar_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI PERTEMUAN
    |--------------------------------------------------------------------------
    */

    public function pertemuan()
    {
        return $this->belongsTo(
            PerencanaanPertemuan::class,
            'perencanaan_pertemuan_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL NILAI SISWA
    |--------------------------------------------------------------------------
    */

    public function details()
    {
        return $this->hasMany(
            PenilaianAkademikDetail::class,
            'penilaian_akademik_id'
        );
    }
}