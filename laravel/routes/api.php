<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\ReviewController;

// Esta es la línea importante:
Route::get('/products', [ProductController::class, 'apiIndex']);
Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});