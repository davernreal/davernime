<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::prefix('anime')->name('anime.')->group(function () {
    Route::get('/', [AnimeController::class, 'index'])->name('index'); // anime.index
    Route::get('/{id}', [AnimeController::class, 'show'])->name('show'); // anime.show
});

Route::get('movie', [AnimeController::class, 'movie'])->name('anime.movie');

Route::middleware('auth')->group(function (){
    Route::get('recommendation', [AnimeController::class, 'recommendation'])->name('recommendation');
    Route::prefix('profile')->name('profile.')->group(function() {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/edit', [ProfileController::class, 'update'])->name('update');
    });
});

require __DIR__ . '/auth.php';