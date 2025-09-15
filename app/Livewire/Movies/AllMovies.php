<?php

namespace App\Livewire\Movies;

use App\Livewire\Traits\HandlesFilterUpdates;
use App\Livewire\Traits\WithMovieFilters;
use App\Livewire\Traits\WithMovieSorting;
use App\Livewire\Traits\WithViewMode;
use App\Models\Movie;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AllMovies extends Component
{
    use WithPagination,
        WithMovieFilters,
        WithMovieSorting,
        WithViewMode,
        HandlesFilterUpdates;

    public string $title = 'Alle Filme';



    public function mount(): void
    {
        $this->initializeMovieSorting();
        $this->initializeWithMovieFilters();
    }

    #[Computed]
    public function movies(): LengthAwarePaginator
    {
        $query = Movie::query()->with(['genres', 'country']);

        $this->applyMovieFilters($query);
        $this->applySorting($query);

        return $query->paginate(30);
    }

    public function render(): View|Factory
    {

        return view('livewire.movies.all-movies', [
            'movies' => $this->movies,
            'sortOptions' => $this->sortOptions,
        ]);
    }
}
