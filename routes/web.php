<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kategori', \App\Http\Controllers\KategoriController::class);
    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::resource('proyek', \App\Http\Controllers\ProyekController::class);
    Route::resource('reimburse', \App\Http\Controllers\ReimburseController::class);
    Route::get('/reimburse/{id}/create', [\App\Http\Controllers\ReimburseDetailController::class, 'create'])->name('reimburse-detail.create');
    Route::post('/reimburse/{id}/create', [\App\Http\Controllers\ReimburseDetailController::class, 'store'])->name('reimburse-detail.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
