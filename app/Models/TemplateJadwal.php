<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateJadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'durasi_jp',
        'jam_masuk',
        'jumlah_jp',
        'istirahat_setelah',
        'durasi_istirahat',
        'ishoma_setelah',
        'durasi_ishoma',
        'aktif',
        'keterangan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function jamPelajaran()
    {
        return $this->hasMany(TemplateJamPelajaran::class);
    }
}