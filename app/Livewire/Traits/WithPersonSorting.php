<?php

namespace App\Livewire\Traits;

trait WithPersonSorting
{
    public string $sortBy = 'popularity_desc';

    public array $sortOptions = [];

    public function initializePersonSorting(): void
    {
        $this->sortOptions = [
            ['value' => 'popularity_desc',   'text' => 'Beliebteste zuerst'],
            ['value' => 'popularity_asc',    'text' => 'Weniger beliebte zuerst'],
            ['value' => 'name_asc',          'text' => 'Name (A-Z)'],
            ['value' => 'name_desc',         'text' => 'Name (Z-A)'],
            ['value' => 'birth_date_desc',   'text' => 'Jüngste zuerst'],
            ['value' => 'birth_date_asc',    'text' => 'Älteste zuerst'],
        ];
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    protected function applySorting($query)
    {
        $parts = explode('_', $this->sortBy);
        $direction = array_pop($parts);
        $column = implode('_', $parts);

        if ($column === 'movies_count') {
            $query->withCount('movies');
        }

        $query->orderBy($column, $direction);

        return $query;
    }
}
