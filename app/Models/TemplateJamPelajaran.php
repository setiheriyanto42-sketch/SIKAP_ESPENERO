<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateJamPelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_jadwal_id',
        'nama_template',
        'jp',
        'jam_mulai',
        'jam_selesai',
        'jenis',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function templateJadwal()
    {
        return $this->belongsTo(
            TemplateJadwal::class
        );
    }
}