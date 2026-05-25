<?php

use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * RUTAS PÚBLICAS
 */
// La raíz ahora carga el índice de productos directamente
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/productes', [ProductController::class, 'index'])->name('productes.index');
// Si tienes un detalle de producto:
Route::get('/productes/{product}', [ProductController::class, 'show'])->name('productes.show');

/**
 * RUTAS DE AUTENTICACIÓN
 */
require __DIR__.'/auth.php';

/**
 * RUTAS PROTEGIDAS (Usuarios logueados)
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/sobre-nosaltres', function () {
        return view('sobre-nosaltres');
    })->name('sobre-nosaltres');

    });

/**
 * RUTAS DE ADMINISTRACIÓN (Protegidas por middleware admin)
 */
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/productes', [ProductAdminController::class, 'index'])->name('productes.index');
    Route::get('/productes/{product}/edit', [ProductAdminController::class, 'edit'])->name('productes.edit');
    Route::put('/productes/{product}', [ProductAdminController::class, 'update'])->name('productes.update');
    Route::get('/import', [ProductImportController::class, 'show'])->name('import.show');
    Route::post('/import', [ProductImportController::class, 'store'])->name('import.store');
});
