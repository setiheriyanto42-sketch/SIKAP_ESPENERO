<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModulAjar extends Model
{
    protected $fillable = [
        'guru_id',
        'nama_file',
        'judul',
        'keterangan',
        'mata_pelajaran',
        'kelas',
        'fase',
        'semester',
        'tahun_ajaran',
        'aktif',
        'alokasi_waktu',
    ];

    protected $casts = [
        'alokasi_waktu' => 'array',
        'aktif' => 'boolean',
    ];

    public function bab(): HasMany
    {
        return $this->hasMany(
            ModulBab::class,
            'modul_ajar_id'
        );
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(
            Guru::class,
            'guru_id'
        );
    }
}