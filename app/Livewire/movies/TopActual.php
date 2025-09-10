<?php

namespace App\Livewire\movies;

use App\Models\Movie;
use Livewire\Component;
use Livewire\WithPagination;

class TopActual extends Component
{
    use WithPagination;

    public string $sortBy = 'rating_desc';
    public array $sortOptions = [];

    public function mount()
    {
        $this->sortOptions = [
            ['value' => 'rating_desc', 'text' => 'Hoch bis niedrig'],
            ['value' => 'rating_asc', 'text' => 'Niedrig bis hoch'],
            ['value' => 'title_asc', 'text' => 'Alphabetisch A-Z'],
            ['value' => 'title_desc', 'text' => 'Alphabetisch Z-A'],
            ['value' => 'release_year_desc', 'text' => 'Neueste zuerst'],
            ['value' => 'release_year_asc', 'text' => 'Älteste zuerst'],
        ];
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $parts = explode('_', $this->sortBy);

        $direction = array_pop($parts);

        $column = implode('_', $parts);
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

        if ($column === 'rating') {
            $query->orderBy('rating', $direction);
        } else {
            $query->orderBy($column, $direction);
        }

        $movies = $query->paginate(10);

        return view('livewire.movies.top-actual', [
            'movies' => $movies,
            'sortOptions' => $this->sortOptions,
        ]);
    }
}
