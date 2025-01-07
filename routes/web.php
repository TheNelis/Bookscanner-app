<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookDataController;
use App\Http\Controllers\BooklistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scannen', function () {
    return view('scannen');
})->middleware(['auth', 'verified'])->name('scannen');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/booklist', [BooklistController::class, 'index'])->name('booklist');

Route::get('/book/{isbn}', [BookDataController::class, 'getBook']);

Route::post('/add-book', [BooklistController::class, 'addBook'])->name('add.book');

Route::delete('/booklist/{id}/delete', [BooklistController::class, 'destroy'])->name('booklist.destroy');

require __DIR__.'/auth.php';
