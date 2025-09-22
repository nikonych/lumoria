<?php

namespace App\Livewire\People;

use App\Models\Movie;
use App\Models\Person;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavoriteButton extends Component
{
    public Person $person;
    public bool $isInFavorites = false;
    public string $size = 'w-12 h-12';
    public string $color = 'text-indigo-700';
    public string $inactiveColor = 'text-indigo-700';

    public function mount(Person $person, string $size = 'w-12 h-12', string $color = 'text-indigo-700', string $inactiveColor = 'text-indigo-700')
    {
        $this->person = $person;
        $this->size = $size;
        $this->color = $color;
        $this->inactiveColor = $inactiveColor;
        $this->checkFavoriteStatus();
    }

    public function checkFavoriteStatus(): void
    {
        if (Auth::check()) {
            $this->isInFavorites = Auth::user()->favoritePeople()
                ->where('people.id', $this->person->id)
                ->exists();
        }
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) {
            return $this->redirect('/login');
        }

        try {
            $user = Auth::user();

            if ($this->isInFavorites) {
                $user->favoritePeople()->detach($this->person->id);
                $this->isInFavorites = false;
            } else {
                $user->favoritePeople()->attach($this->person->id);
                $this->isInFavorites = true;
            }

        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function render()
    {
        return view('livewire.people.favorite-button');
    }
}
