<?php

namespace App\Livewire\Traits;

use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

trait WithMovieFilters
{

    public ?int $countryId = null;
    public array $selectedAgeRatings = [];
    public ?int $selectedRating = null;
    public $selectedGenres = [];

    public array $ageRatings = [];
    public $genres = [];
    public ?int $yearFrom = null;
    public ?int $yearTo = null;

    public function initializeWithMovieFilters(): void
    {

        $this->ageRatings = Movie::distinct()->pluck('age_rating')->sort()->toArray();
        $this->genres = Genre::all();
    }

    #[Computed]
    public function countries()
    {
        return $this->getCountriesWithAll()
            ->map(fn($c) => ['value' => $c->id, 'text' => $c->name])
            ->toArray();
    }

    protected function getCountriesWithAll(): Collection
    {
        $countriesArray = Country::orderBy('name')->get(['id', 'name'])->toArray();
        $allCountriesOption = ['id' => null, 'name' => 'Alle Länder'];
        array_unshift($countriesArray, $allCountriesOption);

        return collect($countriesArray)->map(function ($country) {
            return (object)$country;
        });
    }

    public function updatedCountryId(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedAgeRatings(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedRating(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedGenres(): void
    {
        $this->resetPage();
    }

    public function updatedYearFrom(): void
    {
        $this->resetPage();
    }

    public function updatedYearTo(): void
    {
        $this->resetPage();
    }

    public function updatedMinRating(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'countryId', 'yearFrom', 'yearTo', 'selectedAgeRatings',
            'selectedGenres', 'selectedRating',
        ]);
    }

    protected function applyMovieFilters($query)
    {
        if ($this->countryId) {
            $query->where('original_country_id', $this->countryId);
        }

        if (!empty($this->selectedAgeRatings)) {
            $query->whereIn('age_rating', $this->selectedAgeRatings);
        }

        if (!empty($this->selectedRating)) {
            $query->where('rating', '>=', $this->selectedRating);
        }

        if (!empty($this->selectedGenres)) {
            $query->whereHas('genres', function ($q) {
                $q->whereIn('genres.id', $this->selectedGenres);
            });
        }

        if ($this->yearFrom) {
            $query->where('release_year', '>=', $this->yearFrom);
        }

        if ($this->yearTo) {
            $query->where('release_year', '<=', $this->yearTo);
        }

        return $query;
    }
}
