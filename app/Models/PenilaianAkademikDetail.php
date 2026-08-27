<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianAkademikDetail extends Model
{
    protected $table = 'penilaian_akademik_details';

    protected $fillable = [
        'penilaian_akademik_id',
        'siswa_id',
        'nilai',
        'catatan',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI PENILAIAN AKADEMIK
    |--------------------------------------------------------------------------
    */

    public function penilaianAkademik()
    {
        return $this->belongsTo(
            PenilaianAkademik::class,
            'penilaian_akademik_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI SISWA
    |--------------------------------------------------------------------------
    */

    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'siswa_id'
        );
    }
}