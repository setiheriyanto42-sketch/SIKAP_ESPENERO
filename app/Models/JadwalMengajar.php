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

    /**
     * Scope jadwal aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function sesiMengajars()
    {
        return $this->hasMany(SesiMengajar::class);
    }
}
