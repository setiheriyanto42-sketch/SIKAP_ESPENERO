<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [

        'sesi_mengajar_id',

        'siswa_id',

        'predikat',

        'catatan',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function sesiMengajar()
    {
        return $this->belongsTo(SesiMengajar::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
