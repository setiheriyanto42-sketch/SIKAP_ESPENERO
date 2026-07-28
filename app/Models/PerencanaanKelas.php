<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerencanaanKelas extends Model
{
    protected $table = 'perencanaan_kelas';

    protected $fillable = [
        'perencanaan_pembelajaran_id',
        'kelas_id',
    ];

    public function modul()
    {
        return $this->belongsTo(
            PerencanaanPembelajaran::class,
            'perencanaan_pembelajaran_id'
        );
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}