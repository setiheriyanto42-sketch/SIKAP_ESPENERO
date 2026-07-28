<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerencanaanPembelajaran extends Model
{
    protected $fillable = [

        'guru_id',

        'mata_pelajaran_id',

        'tahun_ajaran_id',

        'tingkat',

        'semester',

        'judul',

        'fase',

        'elemen',

        'alokasi_waktu',

        'keterangan',

        'aktif',

    ];

    protected $casts = [

        'aktif' => 'boolean',

    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function babs()
    {
        return $this->hasMany(PerencanaanBab::class);
    }

    public function kelas()
    {
        return $this->hasMany(PerencanaanKelas::class);
    }

}