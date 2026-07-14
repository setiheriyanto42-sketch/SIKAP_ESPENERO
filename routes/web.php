<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruMengajarController;
use App\Http\Controllers\JadwalMengajarController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\AbsensiMengajarController;
use App\Http\Controllers\JurnalMengajarController;
use App\Http\Controllers\SesiMengajarController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ImportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | IMPORT
    |--------------------------------------------------------------------------
    */

    Route::get('/import', [ImportController::class, 'index'])
        ->name('import.index');

    Route::get('/guru/import', [GuruController::class, 'importForm'])
        ->name('guru.import.form');

    Route::post('/guru/import', [GuruController::class, 'import'])
        ->name('guru.import');

    Route::get('/guru/template', [GuruController::class, 'downloadTemplate'])
        ->name('guru.template');

    /*
    |--------------------------------------------------------------------------
    | KEHADIRAN
    |--------------------------------------------------------------------------
    */

    Route::get('/kehadiran/input', [KehadiranController::class, 'input'])
        ->name('kehadiran.input');

    Route::post('/kehadiran/simpan', [KehadiranController::class, 'simpan'])
        ->name('kehadiran.simpan');

    /*
    |--------------------------------------------------------------------------
    | RESOURCE
    |--------------------------------------------------------------------------
    */

    Route::resource('guru', GuruController::class);

    Route::resource('siswa', SiswaController::class);

    Route::resource('kelas', KelasController::class);

    Route::resource('mata-pelajaran', MataPelajaranController::class)
        ->parameters([
            'mata-pelajaran' => 'mataPelajaran',
        ]);

    Route::resource('tahun-ajaran', TahunAjaranController::class)
        ->parameters([
            'tahun-ajaran' => 'tahunAjaran',
        ]);

    Route::resource('guru-mengajar', GuruMengajarController::class)
        ->parameters([
            'guru-mengajar' => 'guruMengajar',
        ]);

    Route::resource('jadwal-mengajar', JadwalMengajarController::class)
        ->parameters([
            'jadwal-mengajar' => 'jadwalMengajar',
        ]);

    Route::resource('user', UserController::class);

    Route::resource('jurnal-mengajar', JurnalMengajarController::class)
        ->only([
            'create',
            'store',
        ]);

    /*
    |--------------------------------------------------------------------------
    | MENGAJAR
    |--------------------------------------------------------------------------
    */

    Route::get(
        'mengajar/{jadwalMengajar}',
        [AbsensiMengajarController::class, 'index']
    )->name('mengajar.index');

    Route::post(
        'mengajar/{jadwalMengajar}',
        [AbsensiMengajarController::class, 'store']
    )->name('mengajar.store');

    /*
    |--------------------------------------------------------------------------
    | SESI
    |--------------------------------------------------------------------------
    */

    Route::get(
        'sesi-mengajar/{jadwalMengajar}/mulai',
        [SesiMengajarController::class, 'mulai']
    )->name('sesi.mulai');

    Route::post(
        'sesi-mengajar/{sesiMengajar}/selesai',
        [SesiMengajarController::class, 'selesai']
    )->name('sesi.selesai');

    /*
    |--------------------------------------------------------------------------
    | PENILAIAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        'penilaian/{sesiMengajar}',
        [PenilaianController::class, 'create']
    )->name('penilaian.create');

    Route::post(
        'penilaian/{sesiMengajar}',
        [PenilaianController::class, 'store']
    )->name('penilaian.store');

});

require __DIR__.'/auth.php';
