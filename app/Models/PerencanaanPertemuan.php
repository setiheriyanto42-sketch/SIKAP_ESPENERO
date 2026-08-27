<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerencanaanPertemuan extends Model
{
    protected $fillable = [

        'perencanaan_bab_id',

        'pertemuan_ke',

        'judul',

        'materi',

        'tujuan',

        'metode',

        'media',

        'lkpd',

        'asesmen',

        'catatan',

        'refleksi',

        'tanggal',

        'sudah_diajarkan',

        'ada_penilaian',

    ];

    protected $casts = [

        'tanggal' => 'date',

        'sudah_diajarkan' => 'boolean',

        'ada_penilaian' => 'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | RELASI BAB
    |--------------------------------------------------------------------------
    */

    public function bab()
    {
        return $this->belongsTo(
            PerencanaanBab::class,
            'perencanaan_bab_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER MODUL
    |--------------------------------------------------------------------------
    |
    | Modul diperoleh melalui BAB:
    |
    | Pertemuan -> BAB -> Modul Ajar
    |
    */

    public function getModulAttribute()
    {
        return $this->bab?->modul;
    }
}