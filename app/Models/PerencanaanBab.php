<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerencanaanBab extends Model
{
    protected $table = 'perencanaan_babs';

    protected $fillable = [

        'perencanaan_pembelajaran_id',

        'nama_bab',

        'tujuan',

        'jumlah_pertemuan',

        'urutan',

        'aktif',

    ];

    protected $casts = [

        'aktif' => 'boolean',

    ];

    public function modul()
    {
        return $this->belongsTo(
            PerencanaanPembelajaran::class,
            'perencanaan_pembelajaran_id'
        );
    }

    public function pertemuans()
    {
        return $this->hasMany(
            \App\Models\PerencanaanPertemuan::class,
            'perencanaan_bab_id'
        );
    }
}