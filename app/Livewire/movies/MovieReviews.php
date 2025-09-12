<?php

namespace App\Livewire\movies;

use App\Models\Movie;
use Livewire\Component;
use Livewire\WithPagination;

class MovieReviews extends Component
{
    use WithPagination;

    public Movie $movie;
    public int $perPage = 3;

    public function mount(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function render()
    {

        $reviews = $this->movie
            ->reviews()
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.movies.movie-reviews', [
            'reviews' => $reviews
        ])->with(['wire:navigate' => true]);
    }
}
