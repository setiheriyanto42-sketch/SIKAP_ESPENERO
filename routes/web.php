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
use App\Http\Controllers\PreviewImportController;
use App\Http\Controllers\TemplateJamPelajaranController;
use App\Http\Controllers\TemplateJadwalController;
use App\Http\Controllers\PerencanaanPembelajaranController;
use App\Http\Controllers\PerencanaanBabController;
use App\Http\Controllers\PerencanaanPertemuanController;

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

    Route::post(
        '/guru/preview',
        [PreviewImportController::class,'guru']
    )->name('guru.preview');

    Route::get('/guru/template', [GuruController::class, 'downloadTemplate'])
        ->name('guru.template');

    /*
    |--------------------------------------------------------------------------
    | IMPORT SISWA
    |--------------------------------------------------------------------------
    */

    Route::get('/siswa/import', [SiswaController::class,'importForm'])
        ->name('siswa.import.form');

    Route::post('/siswa/import', [SiswaController::class,'import'])
        ->name('siswa.import');

    Route::post('/siswa/preview', [PreviewImportController::class,'siswa'])
        ->name('siswa.preview');

    Route::get('/siswa/template', [SiswaController::class,'downloadTemplate'])
        ->name('siswa.template');


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

    Route::resource('kelas', KelasController::class)
    ->parameters([
        'kelas' => 'kelas',
    ]);

    Route::resource('mata-pelajaran', MataPelajaranController::class)
        ->parameters([
            'mata-pelajaran' => 'mataPelajaran',
        ]);

    Route::resource('tahun-ajaran', TahunAjaranController::class)
        ->parameters([
            'tahun-ajaran' => 'tahunAjaran',
        ]);

    Route::get(
        'guru-mengajar/generate',
        [GuruMengajarController::class, 'generate']
    )->name('guru-mengajar.generate');

    Route::post(
        '/guru-mengajar/generate-semua',
        [GuruMengajarController::class, 'generateSemua']
    )->name('guru-mengajar.generate-semua');

    Route::resource('guru-mengajar', GuruMengajarController::class)
        ->parameters([
            'guru-mengajar' => 'guruMengajar',
        ]);

    Route::get(
        'guru-mengajar/generate',
        [GuruMengajarController::class,'generate']
    )->name('guru-mengajar.generate');

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

    Route::post(
        'template-jadwal/{templateJadwal}/generate',
        [TemplateJadwalController::class, 'generate']
    )->name('template-jadwal.generate');

    Route::resource('template-jam', TemplateJamPelajaranController::class);

    Route::resource('template-jadwal', TemplateJadwalController::class);

    Route::resource(
        'modul-ajar',
        PerencanaanPembelajaranController::class
    )->parameters([
        'modul-ajar' => 'modulAjar'
    ]);

    Route::post(
        'modul-ajar/{modulAjar}/generate-kelas',
        [PerencanaanPembelajaranController::class,'generateKelas']
    )->name('modul-ajar.generate-kelas');

    Route::resource(
        'modul-bab',
        PerencanaanBabController::class
    );

    Route::resource(
        'pertemuan',
        PerencanaanPertemuanController::class
    );

    Route::post(
        'modul-ajar/{modulAjar}/generate-kelas',
        [PerencanaanPembelajaranController::class, 'generateKelas']
    )->name('modul-ajar.generate-kelas');

    Route::get(
        '/modul-bab/create',
        [PerencanaanBabController::class,'create']
    )->name('modul-bab.create');

    Route::post(
        '/modul-bab/store',
        [PerencanaanBabController::class,'store']
    )->name('modul-bab.store');

    Route::resource(
        'modul-pertemuan',
        PerencanaanPertemuanController::class
    );

    Route::post(
    '/bab/{bab}/generate-pertemuan',
    [PerencanaanPertemuanController::class,'generate']
    )->name('bab.generate-pertemuan');

    Route::get(
        '/pertemuan/{pertemuan}',
        [PerencanaanPertemuanController::class,'show']
    )->name('pertemuan.show');

    Route::get(
        '/modul-bab/{bab}/edit',
        [PerencanaanBabController::class,'edit']
    )->name('modul-bab.edit');

    Route::put(
        '/modul-bab/{bab}',
        [PerencanaanBabController::class,'update']
    )->name('modul-bab.update');

    Route::delete(
        '/modul-bab/{bab}',
        [PerencanaanBabController::class,'destroy']
    )->name('modul-bab.destroy');

    Route::get(
        '/pertemuan/{pertemuan}',
        [PerencanaanPertemuanController::class,'show']
    )->name('pertemuan.show');

    Route::put(
        '/pertemuan/{pertemuan}',
        [PerencanaanPertemuanController::class,'update']
    )->name('pertemuan.update');

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
    | JADWAL MENGAJAR
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/jadwal-mengajar/guru',
        [JadwalMengajarController::class, 'guru']
    )->name('jadwal-mengajar.guru');

    Route::get(
        '/jadwal-mengajar/kelas',
        [JadwalMengajarController::class, 'kelas']
    )->name('jadwal-mengajar.kelas');

    Route::get(
        '/jadwal-mengajar/mingguan',
        [JadwalMengajarController::class, 'mingguan']
    )->name('jadwal-mengajar.mingguan');

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

    Route::post(
        'template-jadwal/{templateJadwal}/generate',
        [TemplateJadwalController::class, 'generate']
    )->name('template-jadwal.generate');

});

require __DIR__.'/auth.php';
