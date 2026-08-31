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
use App\Http\Controllers\PenilaianAkademikController;
use App\Http\Controllers\UploadModulAjarController;
use App\Http\Controllers\ModulAjarController;
use App\Http\Controllers\ModulPertemuanController;
use App\Http\Controllers\TemplateHariController;



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

    Route::resource(
        'jurnal-mengajar',
        JurnalMengajarController::class
    )->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
    ]);

    

    Route::get(
        '/modul-ajar/upload',
        [UploadModulAjarController::class, 'create']
    )->name('modul-ajar.upload');

    Route::post(
        '/modul-ajar/upload',
        [UploadModulAjarController::class, 'store']
    )->name('modul-ajar.upload.store');

    Route::get(
        '/modul-ajar/upload/preview',
        [UploadModulAjarController::class, 'preview']
    )->name('modul-ajar.upload.preview');

    Route::delete(
        '/modul-ajar/upload/cancel',
        [UploadModulAjarController::class, 'cancel']
    )->name('modul-ajar.upload.cancel');

    Route::post(
        '/modul-ajar/upload/analyze',
        [UploadModulAjarController::class, 'analyze']
    )->name('modul-ajar.upload.analyze');

    Route::get(
        '/modul-ajar/upload/analysis',
        [UploadModulAjarController::class, 'analysis']
    )->name('modul-ajar.upload.analysis');

    Route::post(
        '/modul-ajar/upload/structure',
        [UploadModulAjarController::class, 'structure']
    )->name('modul-ajar.upload.structure');

    Route::post(
        '/modul-ajar/upload/save',
        [UploadModulAjarController::class,'save']
    )->name('modul-ajar.upload.save');

    
    
    /*
    |--------------------------------------------------------------------------
    | MODUL AJAR
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'modul-ajar',
        ModulAjarController::class
    )->parameters([
        'modul-ajar' => 'modulAjar'
    ]);

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

    Route::get(
        '/penilaian-akademik',
        [PenilaianAkademikController::class, 'index']
    )->name('penilaian-akademik.index');


    Route::get(
        '/penilaian-akademik/{sesiMengajar}/create',
        [PenilaianAkademikController::class, 'create']
    )->name('penilaian-akademik.create');


    Route::post(
        '/penilaian-akademik/{sesiMengajar}',
        [PenilaianAkademikController::class, 'store']
    )->name('penilaian-akademik.store');

    Route::get(
        '/penilaian-akademik/nilai/{penilaianAkademik}',
        [PenilaianAkademikController::class, 'show']
    )->name('penilaian-akademik.show');

    Route::get(
        '/penilaian-akademik/nilai/{penilaianAkademik}/edit',
        [PenilaianAkademikController::class, 'edit']
    )->name('penilaian-akademik.edit');

    Route::put(
        '/penilaian-akademik/nilai/{penilaianAkademik}',
        [PenilaianAkademikController::class, 'update']
    )->name('penilaian-akademik.update');

 
    Route::get(
        'modul-ajar/bab/{bab}/pertemuan/create',
        [ModulPertemuanController::class, 'create']
    )->name('modul-ajar.pertemuan.create');

    Route::post(
        'modul-ajar/bab/{bab}/pertemuan',
        [ModulPertemuanController::class, 'store']
    )->name('modul-ajar.pertemuan.store');


    /*
    |--------------------------------------------------------------------------
    | TEMPLATE JADWAL
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'template-jadwal',
        TemplateJadwalController::class
    )->parameters([
        'template-jadwal' => 'templateJadwal',
    ]);

    Route::post(
        'template-jadwal/{templateJadwal}/generate',
        [TemplateJadwalController::class, 'generate']
    )->name('template-jadwal.generate');

    Route::get(
        'template-jadwal/{templateJadwal}/hari',
        [TemplateJadwalController::class, 'hari']
    )->name('template-jadwal.hari');

    Route::post(
        'template-jadwal/{templateJadwal}/hari',
        [TemplateJadwalController::class, 'updateHari']
    )->name('template-jadwal.update-hari');


    /*
    |--------------------------------------------------------------------------
    | TEMPLATE HARI
    |--------------------------------------------------------------------------
    */

    Route::get(
        'template-hari',
        [TemplateHariController::class, 'index']
    )->name('template-hari.index');

    Route::put(
        'template-hari/{templateHari}',
        [TemplateHariController::class, 'update']
    )->name('template-hari.update');


    /*
    |--------------------------------------------------------------------------
    | TEMPLATE JAM PELAJARAN
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'template-jam',
        TemplateJamPelajaranController::class
    )->parameters([
        'template-jam' => 'templateJam',
    ]);

});

require __DIR__.'/auth.php';
