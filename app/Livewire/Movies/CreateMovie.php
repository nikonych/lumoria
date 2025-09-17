<?php

namespace App\Livewire\Movies;

use App\Livewire\Forms\MovieForm;
use App\Models\Department;
use App\Models\Genre;
use App\Models\Person;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateMovie extends Component
{
    use WithFileUploads;

    public MovieForm $form;

    public array $cast = [];
    public array $crew = [];

    public $genres = [];
    public $people = [];
    public $departments = [];

    public function mount(): void
    {
        $this->genres = Genre::orderBy('name')->get();
        $this->people = Person::orderBy('name')->get();
        $this->departments = Department::orderBy('name')->get();

        $this->addActor();
        $this->addCrewMember();
    }

    public function addActor(): void
    {
        $newId = uniqid();
        $this->cast[$newId] = ['id' => $newId, 'person_id' => '', 'role_name' => ''];
    }

    public function removeActor(string $id): void
    {
        if (count($this->cast) > 1) {
            unset($this->cast[$id]);
        }
    }

    public function clearActor(string $id): void
    {
        if (isset($this->cast[$id])) {
            $this->cast[$id]['person_id'] = '';
            $this->cast[$id]['role_name'] = '';
        }
    }

    public function addCrewMember(): void
    {
        $newId = uniqid();
        $this->crew[$newId] = ['id' => $newId, 'person_id' => '', 'department_id' => '', 'position' => ''];
    }

    public function removeCrewMember(string $id): void
    {
        if (count($this->crew) > 1) {
            unset($this->crew[$id]);
        }
    }

    public function clearCrewMember(string $id): void
    {
        if (isset($this->crew[$id])) {
            $this->crew[$id]['person_id'] = '';
            $this->crew[$id]['department_id'] = '';
            $this->crew[$id]['position'] = '';
        }
    }

    public function save()
    {
        $this->form->store($this->cast, $this->crew);

        session()->flash('message', 'Фильм успешно создан.');
        return $this->redirect('/movies');
    }


    public function render()
    {
        return view('livewire.movies.create-movie');
    }
}
