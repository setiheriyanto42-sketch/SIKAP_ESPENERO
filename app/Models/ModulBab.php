<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModulBab extends Model
{
    protected $fillable = [
        'modul_ajar_id',
        'nomor',
        'judul',
        'isi',
    ];

    public function modulAjar(): BelongsTo
    {
        return $this->belongsTo(
            ModulAjar::class,
            'modul_ajar_id'
        );
    }

    public function pertemuans(): HasMany
    {
        return $this->hasMany(
            ModulPertemuan::class,
            'modul_bab_id'
        )->orderBy('nomor');
    }
}