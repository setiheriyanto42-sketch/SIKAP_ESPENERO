<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalMengajar extends Model
{
    protected $fillable = [

        'sesi_mengajar_id',

        'materi',

        'tujuan',

        'catatan',

        'jumlah_hadir',

        'jumlah_tidak_hadir',

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
}
