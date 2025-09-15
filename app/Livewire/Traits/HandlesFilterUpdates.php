<?php
namespace App\Livewire\Traits;

use Livewire\Attributes\On;

trait HandlesFilterUpdates
{
    #[On('filtersUpdated')]
    public function updateFilters($filters): void
    {
        if (isset($filters['countryId'])) {
            $filters['countryId'] = $filters['countryId'] === '' ? null : (int)$filters['countryId'];
        }
        $this->fill($filters);
        $this->resetPage();
    }
}
