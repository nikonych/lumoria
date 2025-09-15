<?php

namespace App\Livewire\Traits;

use App\Models\Country;
use App\Models\Department; // Предполагаем, что у тебя есть модель для профессий (актер, режиссер)
use App\Models\Language;
use App\Models\Person;
use Illuminate\Support\Collection;

trait WithPersonFilters
{
    public ?int $countryId = null;
    public ?string $nationality = null;
    public ?int $languageId = null;
    public array $selectedDepartments = [];
    public ?int $yearFrom = null;
    public ?int $yearTo = null;

    public Collection $countries;
    public Collection $nationalities;
    public Collection $languages;
    public Collection $departments;


    public function initializeWithPersonFilters(): void
    {
        $this->countries = $this->getCountriesWithAll();
        $this->nationalities = Person::query()->distinct()->whereNotNull('nationality')->orderBy('nationality')->pluck('nationality');
        $this->languages = Language::orderBy('name')->get();
        $this->departments = Department::orderBy('name')->get();
    }

    protected function getCountriesWithAll(): Collection
    {
        $countriesArray = Country::orderBy('name')->get(['id', 'name'])->toArray();
        $allCountriesOption = ['id' => null, 'name' => 'Alle Länder'];
        array_unshift($countriesArray, $allCountriesOption);

        return collect($countriesArray)->map(fn($country) => (object)$country);
    }


    public function updatedCountryId(): void
    {
        $this->resetPage();
    }

    public function updatedNationality(): void
    {
        $this->resetPage();
    }

    public function updatedLanguageId(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedDepartments(): void
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

    public function resetFilters(): void
    {
        $this->reset([
            'countryId',
            'nationality',
            'languageId',
            'selectedDepartments',
            'yearFrom',
            'yearTo',
        ]);

    }

    protected function applyPersonFilters($query)
    {
        if ($this->countryId) {
            $query->where('country_id', $this->countryId);
        }

        if ($this->nationality) {
            $query->where('nationality', $this->nationality);
        }

        if ($this->languageId) {
            $query->whereHas('languages', fn($q) => $q->where('languages.id', $this->languageId));
        }

        if (!empty($this->selectedDepartments)) {
            $query->whereHas('departments', fn($q) => $q->whereIn('departments.id', $this->selectedDepartments));
        }

        if ($this->yearFrom) {
            $query->where('birth_date', '>=', $this->yearFrom);
        }

        if ($this->yearTo) {
            $query->where('birth_date', '<=', $this->yearTo);
        }

        return $query;
    }
}
