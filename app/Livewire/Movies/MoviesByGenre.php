<?php

namespace App\Livewire\Movies;

use App\Livewire\Traits\HandlesFilterUpdates;
use App\Livewire\Traits\WithMovieFilters;
use App\Livewire\Traits\WithMovieSorting;
use App\Livewire\Traits\WithViewMode;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MoviesByGenre extends Component
{
    use WithPagination,
        WithMovieFilters,
        WithMovieSorting,
        WithViewMode,
        HandlesFilterUpdates;

    public ?Genre $genre = null;

    public function mount(): void
    {
        $this->initializeMovieSorting();
        $this->initializeWithMovieFilters();

        $this->genres = Genre::whereKeyNot($this->genre->id)->orderBy('name')->get();
    }

    #[Computed]
    public function movies(): LengthAwarePaginator
    {
        $query = Movie::query()
            ->with('country')
            ->whereHas('genres', function ($q) {
                $q->where('genres.id', $this->genre->id);
            });

        $this->applyMovieFilters($query);
        $this->applySorting($query);

        return $query->paginate(30);
    }

    public function render(): View|Factory
    {
        return view('livewire.movies.movies-by-genre', [
            'movies' => $this->movies,
            'sortOptions' => $this->sortOptions,
        ]);
    }
}
