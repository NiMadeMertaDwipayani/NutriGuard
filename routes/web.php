<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\AdminController; 
use App\Http\Middleware\IsAdmin; 
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home'); // <--- NAMA 'home'

// Rute Pencarian (AJAX - Publik)
Route::get('/search', [FrontController::class, 'search'])->name('search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Rute Hapus Avatar
    Route::delete('/profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');

    // PROFIL KESEHATAN USER 
    Route::get('/my-health', [HealthController::class, 'edit'])->name('health.edit');
    Route::put('/my-health', [HealthController::class, 'update'])->name('health.update');
    // Export PDF
    Route::get('/my-health/export', [HealthController::class, 'exportPdf'])->name('health.export');
    // Rute Hapus Semua
    Route::delete('/my-health/destroy-all', [HealthController::class, 'destroyAll'])->name('health.destroy.all');

    // AREA KHUSUS ADMIN 
    Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard Admin (URL: /admin/dashboard)
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // CRUD Penyakit
        Route::resource('diseases', DiseaseController::class);

        // CRUD Bahan Makanan 
        Route::resource('ingredients', IngredientController::class);

        // CRUD User
        Route::resource('users', UserController::class);

    });
});

require __DIR__.'/auth.php';
