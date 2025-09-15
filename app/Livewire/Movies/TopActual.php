<?php

namespace App\Livewire\Movies;

use App\Livewire\Traits\WithMovieSorting;
use App\Models\Movie;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class TopActual extends Component
{
    use WithPagination,
        WithMovieSorting;


    public function mount(): void
    {
        $this->initializeMovieSorting();
    }

    #[Computed]
    public function movies(): LengthAwarePaginator
    {
        $query = Movie::query()->withCount('reviews');

        if ($user = auth()->user()) {
            $pivotTable = $user->favoriteMovies()->getTable();

            $query->selectSub(function ($subQuery) use ($user, $pivotTable) {
                $subQuery->selectRaw('1') // Select 1 for existence
                ->from($pivotTable)
                    ->where('user_id', $user->id)
                    ->whereColumn('movie_id', 'movies.id')
                    ->limit(1);
            }, 'is_favorite')->withCasts(['is_favorite' => 'boolean']);
        }

        $this->applySorting($query);


        return $query->paginate(10);
    }


    public function render(): View|Factory
    {


        return view('livewire.movies.top-actual', [
            'movies' => $this->movies,
            'sortOptions' => $this->sortOptions,
        ]);
    }
}
