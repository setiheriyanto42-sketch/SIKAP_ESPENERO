<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== IMPORT HARUS DI ATAS =====
    Route::get('/guru/import', [GuruController::class, 'importForm'])
        ->name('guru.import.form');

    Route::post('/guru/import', [GuruController::class, 'import'])
        ->name('guru.import');

    // ===== RESOURCE PALING BAWAH =====
    Route::resource('guru', GuruController::class);

});

require __DIR__.'/auth.php';
