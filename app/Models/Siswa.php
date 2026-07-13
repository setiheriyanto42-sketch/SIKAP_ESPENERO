<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'no_hp',
        'foto',
        'kelas',
        'rombel',
        'aktif',
    ];
}
