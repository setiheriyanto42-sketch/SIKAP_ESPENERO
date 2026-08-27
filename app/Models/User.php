<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'guru_id',
        'role_id',
        'username',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER ROLE
    |--------------------------------------------------------------------------
    */

    public function isAdmin()
    {
        return optional($this->role)->nama_role === 'Admin';
    }

    public function isPetugasAbsensi()
    {
        return optional($this->role)->nama_role === 'Petugas Absensi';
    }

    /*
    |--------------------------------------------------------------------------
    | GURU MAPEL
    |--------------------------------------------------------------------------
    |
    | Mendukung database lama maupun role baru:
    |
    | Guru
    | Guru Mapel
    |
    */

    public function isGuruMapel()
    {
        return in_array(
            optional($this->role)->nama_role,
            [
                'Guru',
                'Guru Mapel',
            ],
            true
        );
    }

    public function isBK()
    {
        return optional($this->role)->nama_role === 'Guru BK';
    }

    public function isWaliKelas()
    {
        return optional($this->role)->nama_role === 'Wali Kelas';
    }

    public function isKepalaSekolah()
    {
        return optional($this->role)->nama_role === 'Kepala Sekolah';
    }
}