<?php

namespace App\Livewire\Traits;

use App\Models\Country;
use App\Models\Department;
use App\Models\Language;
use App\Models\Person;
use Illuminate\Support\Collection;

trait WithPersonFilters
{
    public ?int $countryId = null;
    public ?int $nationalityId = null;
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
        $this->nationalities = Country::orderBy('name')->get();
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

    public function updatedNationalityId(): void
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
            'nationalityId',
            'languageId',
            'selectedDepartments',
            'yearFrom',
            'yearTo',
        ]);

    }

    protected function applyPersonFilters($query)
    {
        if ($this->countryId) {
            $countryNames = Country::where('id', $this->countryId)->pluck('name')->toArray();

            $query->where(function($q) use ($countryNames) {
                foreach ($countryNames as $countryName) {
                    $q->orWhere('birth_place', 'LIKE', '%' . $countryName . '%');
                }
            });
        }
        if ($this->nationalityId) {
            $query->where('nationality_id', $this->nationalityId);

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
