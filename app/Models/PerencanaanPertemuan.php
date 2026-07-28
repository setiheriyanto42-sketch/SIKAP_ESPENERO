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

        'sudah_diajarkan'=>'boolean',
        'ada_penilaian'=>'boolean',

    ];

    public function bab()
    {
        return $this->belongsTo(
            PerencanaanBab::class,
            'perencanaan_bab_id'
        );
    }

    public function modul()
    {
        return $this->bab->modul();
    }

}