<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KuesionerController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Login dan Register
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
});

/*
|--------------------------------------------------------------------------
| Halaman yang Memerlukan Login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Kuesioner profil pengguna
    Route::get('/kuesioner', [KuesionerController::class, 'create'])
        ->name('kuesioner.create');

    Route::post('/kuesioner', [KuesionerController::class, 'store'])
        ->name('kuesioner.store');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Pengaturan Akun
    Route::middleware(['auth'])->group(function () {
        Route::get('/pengaturan', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/pengaturan', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Manajemen tugas
    Route::prefix('tugas')->name('tugas.')->group(function () {
        Route::get('/', [TugasController::class, 'index'])
            ->name('index');

        Route::get('/tambah', [TugasController::class, 'create'])
            ->name('create');

        Route::post('/simpan', [TugasController::class, 'store'])
            ->name('store');

        Route::get('/edit/{id}', [TugasController::class, 'edit'])
            ->name('edit');

        Route::put('/update/{id}', [TugasController::class, 'update'])
            ->name('update');

        Route::delete('/hapus/{id}', [TugasController::class, 'destroy'])
            ->name('destroy');
    });
});
