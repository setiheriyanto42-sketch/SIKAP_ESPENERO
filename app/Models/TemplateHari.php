<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateHari extends Model
{
    use HasFactory;

    protected $table = 'template_haris';

   protected $fillable = [
        'template_jadwal_id',
        'hari',
        'jam_mulai',
        'aktif',
        'istirahat_setelah',
        'durasi_istirahat',
        'ishoma_setelah',
        'durasi_ishoma',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'istirahat_setelah' => 'integer',
        'durasi_istirahat' => 'integer',
        'ishoma_setelah' => 'integer',
        'durasi_ishoma' => 'integer',
    ];

    public function templateJadwal()
    {
        return $this->belongsTo(
            TemplateJadwal::class,
            'template_jadwal_id'
        );
    }

    public function jamPelajaran()
    {
        return $this->hasMany(
            TemplateJamPelajaran::class,
            'template_hari_id'
        );
    }
}