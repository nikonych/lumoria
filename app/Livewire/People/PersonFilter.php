<?php

namespace App\Livewire\People;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PersonFilter extends Component
{
    public $countries;
    public $nationalities;
    public $languages;
    public $departments;

    public $countryId = null;
    public $nationalityId = null;
    public $languageId = null;
    public array $selectedDepartments = [];
    public $yearFrom = null;
    public $yearTo = null;

    private const FILTER_PROPERTIES = [
        'countryId',
        'nationalityId',
        'languageId',
        'selectedDepartments',
        'yearFrom',
        'yearTo',
    ];

    public function mount(
        $countries,
        $nationalities,
        $languages,
        $departments
    ): void {
        $this->countries = $countries;
        $this->nationalities = $nationalities;
        $this->languages = $languages;
        $this->departments = $departments;
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
        return view('livewire.people.person-filter');
    }
}
