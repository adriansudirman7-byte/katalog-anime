<?php

use App\Http\Controllers\AnimeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/anime');
});

Route::get('/anime', [AnimeController::class, 'index'])->name('anime.index');
Route::post('/anime', [AnimeController::class, 'store'])->name('anime.store');
Route::get('/anime/hapus/{id}', [AnimeController::class, 'destroy'])->name('anime.hapus');
Route::get('/anime/edit/{id}', [AnimeController::class, 'edit'])->name('anime.edit');
Route::post('/anime/update/{id}', [AnimeController::class, 'update'])->name('anime.update');