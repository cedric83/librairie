<?php

use App\Http\Controllers\Back\BooksController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::any('/livres', [BooksController::class, 'index'])->name('books.index');
    Route::post('/livres-emprunt', [BooksController::class, 'empruntStore'])->name('books.emprunt.store');
    Route::post('/livres-retour', [BooksController::class, 'retourStore'])->name('books.retour.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
