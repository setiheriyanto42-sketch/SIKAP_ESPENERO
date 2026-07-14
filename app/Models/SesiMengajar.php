<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiMengajar extends Model
{
    protected $fillable = [

        'guru_mengajar_id',

        'jadwal_mengajar_id',

        'tanggal',

        'jam_mulai',

        'jam_selesai',

        'status',

    ];

    protected $casts = [

        'tanggal' => 'date',

        'jam_mulai' => 'datetime',

        'jam_selesai' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function guruMengajar()
    {
        return $this->belongsTo(GuruMengajar::class);
    }

    public function jadwalMengajar()
    {
        return $this->belongsTo(JadwalMengajar::class);
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }

    public function jurnal()
    {
        return $this->hasOne(JurnalMengajar::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }
}
