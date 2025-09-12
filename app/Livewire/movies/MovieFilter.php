<?php

namespace App\Livewire\movies;

use Livewire\Component;

class MovieFilter extends Component
{
    public bool $showGenres;

    public $countries;
    public $ageRatings;
    public $genres;

    public $countryId = null;
    public $yearFrom = null;
    public $yearTo = null;
    public array $selectedAgeRatings = [];
    public array $selectedGenres = [];
    public $selectedRating = null;

    public function mount(
        $countries,
        $ageRatings,
        $genres = [],
        bool $showGenres = true
    ) {
        $this->countries = $countries;
        $this->ageRatings = $ageRatings;
        $this->genres = $genres;
        $this->showGenres = $showGenres;
    }

    public function updated(): void
    {
        $this->dispatch('filtersUpdated', $this->getFilterState());
    }

    public function resetFilters(): void
    {
        $this->reset([
            'countryId',
            'yearFrom',
            'yearTo',
            'selectedAgeRatings',
            'selectedGenres',
            'selectedRating'
        ]);
        $this->dispatch('filtersUpdated', $this->getFilterState());
    }

    private function getFilterState(): array
    {
        return [
            'countryId' => $this->countryId,
            'yearFrom' => $this->yearFrom,
            'yearTo' => $this->yearTo,
            'selectedAgeRatings' => $this->selectedAgeRatings,
            'selectedGenres' => $this->selectedGenres,
            'selectedRating' => $this->selectedRating,
        ];
    }

    public function render()
    {
        return view('livewire.movies.movie-filter');
    }
}
