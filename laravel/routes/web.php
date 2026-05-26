<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/{any}', function () {
    return view('spa');
})->where('any', '.*');

/*
// La raíz ahora carga el índice de productos directamente
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/productes', [ProductController::class, 'index'])->name('productes.index');
// Si tienes un detalle de producto:
Route::get('/productes/{product}', [ProductController::class, 'show'])->name('productes.show');

Route::get('/sobre-nosaltres', function () {
        return view('sobre-nosaltres.index');
    })->name('sobre-nosaltres');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    });


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/productes/{product}/edit', [ProductAdminController::class, 'edit'])->name('productes.edit');
    Route::put('/productes/{product}', [ProductAdminController::class, 'update'])->name('productes.update');
    Route::get('/import', [ProductImportController::class, 'show'])->name('import.show');
    Route::post('/import', [ProductImportController::class, 'store'])->name('import.store');
    Route::post('/import', [ProductImportController::class, 'import'])->name('products.import.store');
});
*/