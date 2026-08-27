<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModulPertemuan extends Model
{
    protected $fillable = [
        'modul_bab_id',
        'nomor',
        'tanggal',
        'jenis',
        'tujuan',
        'materi',
        'aktivitas',
        'asesmen',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function bab(): BelongsTo
    {
        return $this->belongsTo(
            ModulBab::class,
            'modul_bab_id'
        );
    }
}