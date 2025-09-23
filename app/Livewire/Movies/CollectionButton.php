<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use App\Models\UserCollection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CollectionButton extends Component
{
    public Movie $movie;
    public bool $showCollectionModal = false;
    public array $userCollections = [];
    public array $selectedCollections = [];

    public function mount(Movie $movie)
    {
        $this->movie = $movie;
        $this->loadUserCollections();
    }

    public function loadUserCollections()
    {
        if (Auth::check()) {
            $this->userCollections = Auth::user()->collections()
                ->select('id', 'name', 'is_public')
                ->get()
                ->toArray();

            $this->selectedCollections = Auth::user()->collections()
                ->whereHas('movies', function($query) {
                    $query->where('movies.id', $this->movie->id);
                })
                ->pluck('id')
                ->toArray();
        }
    }

    public function openCollectionModal()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->showCollectionModal = true;
        $this->loadUserCollections();
    }

    public function closeCollectionModal()
    {
        $this->showCollectionModal = false;
    }

    public function updateMovieCollections()
    {
        try {
            $currentCollections = Auth::user()->collections()
                ->whereHas('movies', function($query) {
                    $query->where('movies.id', $this->movie->id);
                })
                ->pluck('id')
                ->toArray();

            $toAdd = array_diff($this->selectedCollections, $currentCollections);

            $toRemove = array_diff($currentCollections, $this->selectedCollections);

            foreach ($toAdd as $collectionId) {
                $collection = UserCollection::find($collectionId);
                if ($collection && $collection->user_id === Auth::id()) {
                    $collection->movies()->attach($this->movie->id);
                }
            }

            foreach ($toRemove as $collectionId) {
                $collection = UserCollection::find($collectionId);
                if ($collection && $collection->user_id === Auth::id()) {
                    $collection->movies()->detach($this->movie->id);
                }
            }

            $this->closeCollectionModal();
            session()->flash('collection-message', 'Sammlungen aktualisiert');

        } catch (\Exception $e) {
            session()->flash('error', 'Fehler beim Aktualisieren der Sammlungen');
        }
    }

    public function render()
    {
        return view('livewire.movies.collection-button');
    }
}
