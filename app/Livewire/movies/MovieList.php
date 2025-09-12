<?php

namespace App\Livewire\movies;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class MovieList extends Component
{
    use WithPagination;

    public string $type;
    public ?string $title = null;
    public ?Movie $movie = null;

    public function mount(string $type, ?string $title, Movie $movie = null)
    {
        $this->type = $type;
        $this->title = $title;
        $this->movie = $movie;
    }

    public function render()
    {
        $movies = collect();
        $user = auth()->user();


        if ($this->type === 'watchlist') {
            $movies = $user->watchlist()->paginate(5);
        } elseif ($this->type === 'recommendations') {
            $movies = $user->recommendations()->paginate(5);
        } elseif ($this->type === 'similar') {
            if ($this->movie) {
                $genreIds = $this->movie->genres()->pluck('genres.id');
                $movies = Movie::query()
                    ->whereHas('genres', function (Builder $query) use ($genreIds) {
                        $query->whereIn('genres.id', $genreIds);
                    })
                    ->where('movies.id', '!=', $this->movie->id)
                    ->orderByDesc('rating')
                    ->paginate(6);
            }
        }

        return view('livewire.movies.movie-list', [
            'movies' => $movies,
        ])->with(['wire:navigate' => true]);
    }
}
