<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
        'aktif',
    ];

    /**
     * Relasi Penugasan Mengajar
     */
    public function mengajar()
    {
        return $this->hasMany(GuruMengajar::class);
    }
}
