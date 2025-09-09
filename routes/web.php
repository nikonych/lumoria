<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Livewire\FilmsTopActual;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('movies', [FilmController::class, 'index'])->name('movies');
Route::get('movies/genres', [FilmController::class, 'genres'])->name('genres');
Route::get('movies/top-actual', FilmsTopActual::class)->name('top_actual');
Route::get('movies/all', [FilmController::class, 'all'])->name('all');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
