<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FilmController extends Controller
{
    public function index(): View
    {
        return view('pages.films');
    }

    public function genres(): View
    {
        return view('pages.movies.all-genres');
    }

    public function all(): View
    {
        return view('pages.movies.all-movies');
    }
}
