<?php

namespace App\Livewire\People;

use App\Livewire\Traits\HandlesFilterUpdates;
use App\Livewire\Traits\WithMovieFilters;
use App\Livewire\Traits\WithMovieSorting;
use App\Livewire\Traits\WithPersonFilters;
use App\Livewire\Traits\WithPersonSorting;
use App\Livewire\Traits\WithViewMode;
use App\Models\Movie;
use App\Models\Person;
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


    public function mount(): void
    {
        $this->initializeWithPersonFilters();
        $this->initializePersonSorting();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function people(): LengthAwarePaginator
    {
        $query = Person::query()->with(['departments']);

        $this->applyPersonFilters($query);
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
