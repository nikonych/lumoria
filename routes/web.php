<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(MovieController::class)->prefix('movies')->name('movies.')->group(function () {
    Route::get('/', 'index')->name('index'); // Was 'movies'
    Route::get('/genres', 'genres')->name('genres');
    Route::get('/top-actual', 'topActual')->name('top-actual'); // Changed name to kebab-case
    Route::get('/all', 'all')->name('all');
    Route::get('/new', 'new')->name('new');
    Route::get('/genre/{genre}', 'showByGenre')->name('by-genre');
    Route::get('/{movie}', 'movieDetails')->name('details');
});

Route::controller(PersonController::class)->prefix('people')->name('people.')->group(function () {
    Route::get('/', 'index')->name('index'); // Was 'people'
    Route::get('/all', 'all')->name('all');
    Route::get('/{person}', 'personDetails')->name('details');

});

require __DIR__.'/auth.php';
