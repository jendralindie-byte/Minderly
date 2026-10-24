<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TugasController;
use App\Http\Controllers\DashboardController;

Route::get(
'/tugas',
[TugasController::class,'index']
);

Route::get(
'/tugas/tambah',
[TugasController::class,'create']
);

Route::post(
'/tugas/simpan',
[TugasController::class,'store']
);

Route::get(
'/tugas/edit/{id}',
[TugasController::class,'edit']
);

Route::put(
'/tugas/update/{id}',
[TugasController::class,'update']
);

Route::delete(
'/tugas/hapus/{id}',
[TugasController::class,'destroy']
);

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index']);