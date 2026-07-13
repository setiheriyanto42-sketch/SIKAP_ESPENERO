<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Relasi Penugasan Mengajar
     */
    public function guruMengajars()
    {
        return $this->hasMany(GuruMengajar::class);
    }

    /**
     * Scope Tahun Ajaran Aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
