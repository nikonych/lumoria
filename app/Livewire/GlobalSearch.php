<?php

namespace App\Livewire;

use App\Models\Movie;
use App\Models\Person;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $searchQuery = '';
    public $movies = [];
    public $people = [];
    public $maxResults = 5;

    public function updatedSearchQuery()
    {
        if (strlen($this->searchQuery) >= 2) {
            $this->performSearch();
        } else {
            $this->clearResults();
        }
    }

    public function performSearch()
    {
        $this->movies = Movie::where('title', 'like', '%' . $this->searchQuery . '%')
            ->orWhere('description', 'like', '%' . $this->searchQuery . '%')
            ->limit($this->maxResults)
            ->get(['id', 'title', 'release_year', 'poster_image']);

        $this->people = Person::where('name', 'like', '%' . $this->searchQuery . '%')
            ->limit($this->maxResults)
            ->get(['id', 'name', 'profile_image']);
    }

    public function clearResults()
    {
        $this->movies = collect([]);
        $this->people = collect([]);
    }

    public function selectResult($type, $id)
    {
        $this->searchQuery = '';
        $this->clearResults();

        if ($type === 'movie') {
            return $this->redirect(route('movies.details', $id));
        } elseif ($type === 'person') {
            return $this->redirect(route('people.details', $id));
        }
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
