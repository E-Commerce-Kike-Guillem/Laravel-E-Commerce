<?php

use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/import', [ProductImportController::class, 'show'])->name('import.show');
    Route::post('/import', [ProductImportController::class, 'store'])->name('import.store');
});

Route::get('/productes', [ProductController::class, 'index'])->name('products.index');

require __DIR__.'/auth.php';
