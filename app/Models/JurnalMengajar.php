<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalMengajar extends Model
{
    protected $fillable = [

        'sesi_mengajar_id',

        'perencanaan_pertemuan_id',

        'materi',

        'materi_tercapai',

        'tujuan',

        'catatan',

        'refleksi',

        'jumlah_hadir',

        'jumlah_tidak_hadir',

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
    | RELASI PERENCANAAN PERTEMUAN
    |--------------------------------------------------------------------------
    */

    public function perencanaanPertemuan()
    {
        return $this->belongsTo(
            PerencanaanPertemuan::class,
            'perencanaan_pertemuan_id'
        );
    }
}