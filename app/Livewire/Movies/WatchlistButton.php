<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WatchlistButton extends Component
{
    public Movie $movie;
    public bool $isInWatchlist = false;

    public function mount(Movie $movie)
    {
        $this->movie = $movie;
        $this->checkWatchlistStatus();
    }

    public function checkWatchlistStatus()
    {
        if (Auth::check()) {
            $this->isInWatchlist = Auth::user()->watchlist()
                ->where('movies.id', $this->movie->id)
                ->exists();
        }
    }

    public function toggleWatchlist()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $user = Auth::user();

            if ($this->isInWatchlist) {
                $user->watchlist()->detach($this->movie->id);
                $this->isInWatchlist = false;
                session()->flash('watchlist-message', 'Film aus der Watchlist entfernt');
            } else {
                $user->watchlist()->attach($this->movie->id);
                $this->isInWatchlist = true;
                session()->flash('watchlist-message', 'Film zur Watchlist hinzugefügt');
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Fehler beim Aktualisieren der Watchlist');
        }
    }

    public function render()
    {
        return view('livewire.movies.watchlist-button');
    }
}
