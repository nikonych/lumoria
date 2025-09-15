<?php

namespace App\Livewire\Movies;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MovieFilter extends Component
{


    public $countries;
    public $ageRatings;
    public $genres;

    public $countryId = null;
    public $yearFrom = null;
    public $yearTo = null;
    public array $selectedAgeRatings = [];
    public array $selectedGenres = [];
    public $selectedRating = null;

    private const FILTER_PROPERTIES = [
        'countryId',
        'yearFrom',
        'yearTo',
        'selectedAgeRatings',
        'selectedGenres',
        'selectedRating',
    ];

    public function mount(
        $countries,
        $ageRatings,
        $genres = [],
    ): void
    {
        $this->countries = $countries;
        $this->ageRatings = $ageRatings;
        $this->genres = $genres;
    }

    public function updated(string $propertyName): void
    {
        $basePropertyName = explode('.', $propertyName)[0];

        if (in_array($basePropertyName, self::FILTER_PROPERTIES)) {
            $this->dispatch('filtersUpdated', $this->getFilterState());
        }
    }

    public function resetFilters(): void
    {
        $this->reset(self::FILTER_PROPERTIES);
        $this->dispatch('filtersUpdated', $this->getFilterState());
    }

    private function getFilterState(): array
    {
        return collect($this->all())
            ->only(self::FILTER_PROPERTIES)
            ->toArray();
    }

    public function render(): View|Factory
    {
        return view('livewire.movies.movie-filter');
    }
}
