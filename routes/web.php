<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(MovieController::class)->prefix('movies')->name('movies.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/genres', 'genres')->name('genres');
    Route::get('/top-actual', 'topActual')->name('top-actual');
    Route::get('/all', 'all')->name('all');
    Route::get('/new', 'new')->name('new');

    Route::get('/create', 'create')->name('create');

    Route::get('/genre/{genre}', 'showByGenre')->name('by-genre');
    Route::get('/{movie}', 'movieDetails')->name('details');
});

Route::controller(PersonController::class)->prefix('people')->name('people.')->group(function () {
    Route::get('/', 'index')->name('index'); // Was 'people'
    Route::get('/all', 'all')->name('all');
    Route::get('/with-awards', 'withAwards')->name('withAwards');

    Route::get('/actors', fn() => app(PersonController::class)->showByDepartmentSlug('Schauspieler'))->name('actors');
    Route::get('/regisseurs', fn() => app(PersonController::class)->showByDepartmentSlug('Regie'))->name('regisseurs');
    Route::get('/producers', fn() => app(PersonController::class)->showByDepartmentSlug('Produktion'))->name('producers');
    Route::get('/writers', fn() => app(PersonController::class)->showByDepartmentSlug('Drehbuch'))->name('writers');
    Route::get('/musicians', fn() => app(PersonController::class)->showByDepartmentSlug('Musik'))->name('musicians');
    Route::get('/cameramen', fn() => app(PersonController::class)->showByDepartmentSlug('Kamera & Beleuchtung'))->name('cameramen');
    Route::get('/editors', fn() => app(PersonController::class)->showByDepartmentSlug('Schnitt'))->name('editors');

    Route::get('/create', 'create')->name('create');

    Route::get('/{person}', 'personDetails')->name('details');

});

Route::get('/phpinfo', function () {
    return response()->json([
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'max_file_uploads' => ini_get('max_file_uploads'),
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time'),
        'max_input_vars' => ini_get('max_input_vars'),
    ]);
});

require __DIR__.'/auth.php';
