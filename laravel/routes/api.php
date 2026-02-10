<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\ReviewController;

// --- API V1 ---

// 1. Llistat de productes (amb ?page=1 i ?q=busqueda)
Route::get('/products', [ProductController::class, 'apiIndex']);

// 2. Detall d'un producte concret
Route::get('/products/{id}', [ProductController::class, 'apiShow']);

// 3. Reviews (Ja ho tenies de l'exemple anterior)
Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);

// Usuari (per defecte)
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});