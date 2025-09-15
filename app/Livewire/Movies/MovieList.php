<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class MovieList extends Component
{
    use WithPagination;

    public string $type;
    public ?string $title = null;
    public ?Movie $movie = null;

    public function mount(string $type, ?string $title, Movie $movie = null): void
    {
        $this->type = $type;
        $this->title = $title;
        $this->movie = $movie;
    }

    #[Computed]
    public function movies(): LengthAwarePaginator
    {
        $movieService = resolve(MovieService::class);
        return $movieService->getMoviesForList($this->type, $this->movie);
    }

    public function render(): View|Factory
    {
        return view('livewire.movies.movie-list', [
            'movies' => $this->movies,
        ]);
    }
}
