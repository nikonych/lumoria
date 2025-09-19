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
    public string $newCollectionName = '';
    public bool $newCollectionIsPublic = false;

    public function mount(Movie $movie)
    {
        $this->movie = $movie;
        $this->loadUserCollections();
    }

    public function loadUserCollections()
    {
        if (Auth::check()) {
            // Получаем коллекции пользователя
            $this->userCollections = Auth::user()->collections()
                ->select('id', 'name', 'is_public')
                ->get()
                ->toArray();

            // Проверяем какие коллекции уже содержат этот фильм
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
        $this->newCollectionName = '';
        $this->newCollectionIsPublic = false;
    }

    public function createNewCollection()
    {
        $this->validate([
            'newCollectionName' => 'required|string|max:255',
        ]);

        try {
            $collection = UserCollection::create([
                'user_id' => Auth::id(),
                'name' => $this->newCollectionName,
                'is_public' => $this->newCollectionIsPublic,
            ]);

            $this->newCollectionName = '';
            $this->newCollectionIsPublic = false;
            $this->loadUserCollections();

            session()->flash('collection-message', 'Neue Sammlung erstellt');

        } catch (\Exception $e) {
            session()->flash('error', 'Fehler beim Erstellen der Sammlung');
        }
    }

    public function updateMovieCollections()
    {
        try {
            // Получаем текущие коллекции с этим фильмом
            $currentCollections = Auth::user()->collections()
                ->whereHas('movies', function($query) {
                    $query->where('movies.id', $this->movie->id);
                })
                ->pluck('id')
                ->toArray();

            // Коллекции для добавления
            $toAdd = array_diff($this->selectedCollections, $currentCollections);

            // Коллекции для удаления
            $toRemove = array_diff($currentCollections, $this->selectedCollections);

            // Добавляем фильм в выбранные коллекции
            foreach ($toAdd as $collectionId) {
                $collection = UserCollection::find($collectionId);
                if ($collection && $collection->user_id === Auth::id()) {
                    $collection->movies()->attach($this->movie->id);
                }
            }

            // Удаляем фильм из невыбранных коллекций
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
