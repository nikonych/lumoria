<?php

namespace App\Livewire\People;

use App\Livewire\Traits\HandlesFilterUpdates;
use App\Livewire\Traits\WithPersonFilters;
use App\Livewire\Traits\WithPersonSorting;
use App\Livewire\Traits\WithViewMode;
use App\Models\Person;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AllPeople extends Component
{
    use WithPagination,
        WithPersonFilters,
        WithPersonSorting,
        WithViewMode,
        HandlesFilterUpdates;

    public string $title = 'Alle Personen';
    public int $perPage = 6;
    public bool $withAwards = false;


    public function mount($preselectedDepartmentId = null): void
    {
        $this->initializeWithPersonFilters();
        $this->initializePersonSorting();
        if ($preselectedDepartmentId) {
            $this->selectedDepartments = [$preselectedDepartmentId];
        }
    }

    private function getFilteredQuery(): Builder|Person
    {
        $query = Person::query()->with(['departments']);

        if ($this->withAwards) {
            $query->has('awards');
        }

        $this->applyPersonFilters($query);

        return $query;
    }


    public function updatedPerPage(): void
    {
        $currentPage = $this->getPage();
        $totalItems = $this->getFilteredQuery()->count();
        $maxPage = ceil($totalItems / $this->perPage);

        if ($currentPage > $maxPage) {
            $this->resetPage();
        }
    }


    #[Computed]
    public function people(): LengthAwarePaginator
    {
        $query = $this->getFilteredQuery();
        $this->applySorting($query);

        return $query->paginate($this->perPage);
    }

    public function render(): View|Factory
    {

        return view('livewire.people.all-people', [
            'people' => $this->people,
            'sortOptions' => $this->sortOptions,
        ]);
    }
}
