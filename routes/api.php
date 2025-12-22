<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IngredientController;

// === PINTU UMUM (Bisa diakses siapa saja) ===
Route::post('/login', [AuthController::class, 'login']);
Route::get('/ingredients', [IngredientController::class, 'index']); // Baca data boleh publik

// === PINTU KHUSUS (Harus punya Token / Login) ===
// Ini memenuhi syarat Bonus "Proteksi Endpoint" [cite: 194]
Route::middleware('auth:api')->group(function () {
    Route::post('/ingredients', [IngredientController::class, 'store']);   // Tambah Data
    Route::delete('/ingredients/{id}', [IngredientController::class, 'destroy']); // Hapus Data
    Route::post('/logout', [AuthController::class, 'logout']);
});
