<?php
namespace App\Livewire\Traits;

trait WithMovieSorting
{
    public string $sortBy = 'rating_desc';
    public array $sortOptions = [];

    public function initializeMovieSorting(): void
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

    public function updatedSortBy($property): void
    {
        $filterProperties = [
            'sortBy'
        ];

        if (in_array($property, $filterProperties)) {
            $this->resetPage(); // Reset pagination when sorting changes
        }
    }

    protected function applySorting($query)
    {
        $parts = explode('_', $this->sortBy);
        $direction = array_pop($parts);
        $column = implode('_', $parts);

        $query = $query->withCount('reviews');

        $query->orderBy($column, $direction);

        return $query;
    }

}
