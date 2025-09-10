<?php

namespace App\Livewire\movies;

use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use Livewire\Component;
use Livewire\WithPagination;

class AllMovies extends Component
{
    use WithPagination;

    public string $sortBy = 'rating_desc';
    public string $title = 'Alle Filme';
    public array $sortOptions = [];
    public ?int $countryId = null;
    public array $selectedGenres = [];
    public array $selectedAgeRatings = [];
    public ?int $selectedRating = null;
    public $countries = [];
    public $genres = [];
    public array $ageRatings = [];
    public ?int $yearFrom = null;
    public ?int $yearTo = null;
    public ?int $minRating = null;
    public string $viewMode = 'list';

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

        // Get countries and convert to a plain array to avoid hydration issues
        $countriesArray = Country::orderBy('name')->get(['id', 'name'])->toArray();

        // Create the "All Countries" option as an array
        $allCountriesOption = ['id' => null, 'name' => 'Alle Länder'];

        // Prepend the "All Countries" option to the beginning of the array
        array_unshift($countriesArray, $allCountriesOption);

        // Convert the final array back to a collection of objects
        $this->countries = collect($countriesArray)->map(function ($country) {
            return (object) $country;
        });

        $this->genres = Genre::orderBy('name')->get();
        $this->ageRatings = Movie::distinct()->pluck('age_rating')->sort()->toArray();;
    }

    public function updating($property): void
    {
        if (
            $property === 'countryId' ||
            $property === 'yearFrom' ||
            $property === 'yearTo' ||
            $property === 'selectedGenres' ||
            $property === 'selectedAgeRatings' ||
            $property === 'selectedRating' ||
            $property === 'minRating' ||
            $property === 'sortBy'
        ) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['countryId', 'yearFrom', 'yearTo', 'selectedGenres', 'selectedAgeRatings', 'selectedRating', 'minRating', 'sortBy']);
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    public function setView(string $mode): void
    {
        if (in_array($mode, ['grid', 'list'])) {
            $this->viewMode = $mode;
        }
    }

    public function render()
    {
        $query = Movie::query()->with(['genres', 'country']);

        if ($this->countryId) {
            $query->where('country_id', $this->countryId);
        }
        if (!empty($this->selectedGenres)) {
            $query->whereHas('genres', function ($q) {
                $q->whereIn('genres.id', $this->selectedGenres);
            });
        }
        if (!empty($this->selectedAgeRatings)) {
            $query->whereIn('age_rating', $this->selectedAgeRatings);
        }
        if (!empty($this->selectedRating)) {
            $query->where('rating', '>=', $this->selectedRating);
        }

        if ($this->yearFrom) {
            $query->where('release_year', '>=', $this->yearFrom);
        }

        if ($this->yearTo) {
            $query->where('release_year', '<=', $this->yearTo);
        }

        $parts = explode('_', $this->sortBy);

        $direction = array_pop($parts);

        $column = implode('_', $parts);
        $query = $query->withCount('reviews');

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

        $movies = $query->paginate(30);

        return view('livewire.movies.all-movies', [
            'movies' => $movies,
            'sortOptions' => $this->sortOptions,
        ]);
    }
}
