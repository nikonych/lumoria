<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(): View
    {
        return view('pages.movies');
    }

    public function genres(): View
    {
        $genres = Genre::whereHas('movies')
            ->with(['movies' => function ($query) {
                $query->limit(1);
            }])
            ->get();

        return view('pages.movies.all-genres', ['genres' => $genres]);
    }

    public function all(): View
    {
        return view('pages.movies.all-movies');
    }

    public function new(): View
    {
        return view('pages.movies.new-movies');
    }

    public function top_actual(): View
    {
        return view('pages.movies.top-actual');
    }

    public function showByGenre(Genre $genre): View
    {
        $movies = $genre->movies()->paginate(30);

        return view('pages.movies.movies-by-genre', compact('genre', 'movies'));
    }

    public function movieDetails(Movie $movie): View
    {
        $movie->loadCount('reviews');
        $movie->loadAvg('reviews', 'rating');

        $ratingDistribution = $movie->reviews()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->pluck('count', 'rating')
            ->toArray();

        $totalReviews = $movie->reviews_count;
        $ratingPercentages = [];

        for ($i = 5; $i >= 1; $i--) {
            $count = $ratingDistribution[$i] ?? 0;
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
            $ratingPercentages[$i] = $percentage;
        }

        return view('pages.movies.details', compact('movie', 'ratingPercentages'));
    }
}
