<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class MovieReviews extends Component
{
    use WithPagination;

    public Movie $movie;
    public int $perPage = 3;

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;
    }

    #[Computed]
    public function reviews()
    {
        return $this->movie
            ->reviews()
            ->with('user')
            ->latest()
            ->paginate($this->perPage);
    }

    public function render(): View|Factory
    {

        return view('livewire.movies.movie-reviews', [
            'reviews' => $this->reviews
        ])->with(['wire:navigate' => true]);
    }
}
