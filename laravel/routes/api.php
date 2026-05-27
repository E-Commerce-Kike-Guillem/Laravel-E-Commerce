<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\ProductImportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutes d'autenticació
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);

// Rutes d'usuari
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Rutes de productes (Públiques)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// RUTA DE IMPORTACIÓ (Única y protegida)
Route::middleware(['auth:sanctum', 'admin'])->post('/products/import', [ProductImportController::class, 'import']);