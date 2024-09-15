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
    Route::get('/reimburse/report', [\App\Http\Controllers\ReimburseController::class, 'report'])->name('reimburse.report');
    Route::post('/reimburse/report', [\App\Http\Controllers\ReimburseController::class, 'exportReport'])->name('reimburse.export-report');
    Route::resource('reimburse', \App\Http\Controllers\ReimburseController::class);
    Route::post('/reimburse/{id}/send', [\App\Http\Controllers\ReimburseController::class, 'send'])->name('reimburse.send');
    Route::post('/reimburse/{id}/hr-accept', [\App\Http\Controllers\ReimburseController::class, 'hrAccept'])->name('reimburse.hr-accept');
    Route::post('/reimburse/{id}/hr-reject', [\App\Http\Controllers\ReimburseController::class, 'hrReject'])->name('reimburse.hr-reject');
    Route::post('/reimburse/{id}/finance-accept', [\App\Http\Controllers\ReimburseController::class, 'financeAccept'])->name('reimburse.finance-accept');
    Route::post('/reimburse/{id}/finance-reject', [\App\Http\Controllers\ReimburseController::class, 'financeReject'])->name('reimburse.finance-reject');
    Route::get('/reimburse/{id}/upload-proof', [\App\Http\Controllers\ReimburseController::class, 'uploadProof'])->name('reimburse.upload-proof');
    Route::post('/reimburse/{id}/store-proof', [\App\Http\Controllers\ReimburseController::class, 'storeProof'])->name('reimburse.store-proof');
    Route::get('/reimburse/{id}/create', [\App\Http\Controllers\ReimburseDetailController::class, 'create'])->name('reimburse-detail.create');
    Route::post('/reimburse/{id}/create', [\App\Http\Controllers\ReimburseDetailController::class, 'store'])->name('reimburse-detail.store');
    Route::get('/reimburse-detail/{id}/edit', [\App\Http\Controllers\ReimburseDetailController::class, 'edit'])->name('reimburse-detail.edit');
    Route::put('/reimburse-detail/{id}/edit', [\App\Http\Controllers\ReimburseDetailController::class, 'update'])->name('reimburse-detail.update');
    Route::delete('/reimburse-detail/{id}/destroy', [\App\Http\Controllers\ReimburseDetailController::class, 'destroy'])->name('reimburse-detail.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
