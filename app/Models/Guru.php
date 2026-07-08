<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'no_hp',
        'email',
        'alamat',
        'foto',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
