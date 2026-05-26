<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController; // Importa el controlador correcte

// Ruta per obtenir el perfil d'usuari autenticat
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Rutes d'API de productes (Sense auth, tal com demanaves)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);

// Esta ruta ya viene protegida por Sanctum, nos devolverá el usuario si la cookie es válida
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});