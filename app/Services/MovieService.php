<?php
namespace App\Services;

use App\Models\Movie;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class MovieService
{
    public function getMoviesForList(string $type, ?Movie $movie = null): LengthAwarePaginator
    {
        $user = Auth::user();

        return match ($type) {
            'watchlist' => $user->watchlist()->paginate(5),
            'recommendations' => $user->recommendations()->paginate(5),
            'similar' => $this->getSimilarMovies($movie),
            default => Movie::query()->paginate(5),
        };
    }

    private function getSimilarMovies(Movie $movie): LengthAwarePaginator
    {
        $genreIds = $movie->genres()->pluck('genres.id');

        return Movie::query()
            ->whereHas('genres', fn($query) => $query->whereIn('genres.id', $genreIds))
            ->where('movies.id', '!=', $movie->id)
            ->orderByDesc('rating')
            ->paginate(6);
    }
}
