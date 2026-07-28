<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalMengajar extends Model
{
    protected $fillable = [
        'guru_mengajar_id',
        'hari',
        'jam_ke',
        'jam_mulai',
        'jam_selesai',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function guruMengajar()
    {
        return $this->belongsTo(GuruMengajar::class);
    }

    public function sesiMengajars()
    {
        return $this->hasMany(SesiMengajar::class);
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}