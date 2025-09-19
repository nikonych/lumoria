<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavoriteButton extends Component
{
    public Movie $movie;
    public bool $isInFavorites = false;
    public string $size = 'w-12 h-12';
    public string $color = 'text-indigo-700';
    public string $inactiveColor = 'text-indigo-700';

    public function mount(Movie $movie, string $size = 'w-12 h-12', string $color = 'text-indigo-700', string $inactiveColor = 'text-indigo-700')
    {
        $this->movie = $movie;
        $this->size = $size;
        $this->color = $color;
        $this->inactiveColor = $inactiveColor;
        $this->checkFavoriteStatus();
    }

    public function checkFavoriteStatus()
    {
        if (Auth::check()) {
            $this->isInFavorites = Auth::user()->favoriteMovies()
                ->where('movies.id', $this->movie->id)
                ->exists();
        }
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) {
            return $this->redirect('/login');
        }

        try {
            $user = Auth::user();

            if ($this->isInFavorites) {
                $user->favoriteMovies()->detach($this->movie->id);
                $this->isInFavorites = false;
            } else {
                $user->favoriteMovies()->attach($this->movie->id);
                $this->isInFavorites = true;
            }

        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function render()
    {
        return view('livewire.movies.favorite-button');
    }
}
