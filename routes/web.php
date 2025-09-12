<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('movies', [MovieController::class, 'index'])->name('movies');
Route::get('movies/genres', [MovieController::class, 'genres'])->name('genres');
Route::get('movies/top-actual', [MovieController::class, 'topActual'])->name('topActual');
Route::get('movies/all', [MovieController::class, 'all'])->name('all');
Route::get('movies/new', [MovieController::class, 'new'])->name('new');

Route::get('/movies/genre/{genre}', [MovieController::class, 'showByGenre'])->name('movies.by-genre');
Route::get('/movies/{movie}', [MovieController::class, 'movieDetails'])->name('movies.details');


Route::get('people', [PersonController::class, 'index'])->name('people');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
