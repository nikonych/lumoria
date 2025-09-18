<?php

namespace App\Livewire\Movies;

use App\Enums\AgeRating;
use App\Livewire\Forms\MovieForm;
use App\Livewire\Traits\CreateMovie\ManagesAwards;
use App\Livewire\Traits\CreateMovie\ManagesCast;
use App\Livewire\Traits\CreateMovie\ManagesCrew;
use App\Livewire\Traits\HandleFormValidation;
use App\Models\Award;
use App\Models\Country;
use App\Models\Department;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Person;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateMovie extends Component
{
    use WithFileUploads;
    use ManagesCast, ManagesCrew, ManagesAwards;
    use HandleFormValidation;

    public MovieForm $form;

    public array $photos = [];
    public array $ageRatingOptions = [];
    public $genres = [];
    public $people = [];
    public $departments = [];

    protected $listeners = ['photosUpdated' => 'handlePhotosUpdate'];

    public function updatedPhotos(): void
    {
        $this->form->photos = $this->photos;
        $this->validateOnly('photos');
    }

    public function removePhoto($index): void
    {
        unset($this->photos[$index]);
        $this->photos = array_values($this->photos);
        $this->form->photos = $this->photos;
    }

    public function updatePhotos(array $photos): void
    {
        $this->form->photos = $photos;
        $this->photos = $photos;
    }

    public function handlePhotosUpdate($photos): void
    {
        $this->photos = $photos;
        $this->form->photos = $photos;
    }

    public function getCountriesProperty()
    {
        return cache()->remember('countries_options', 3600, function() {
            return Country::orderBy('name')
                ->get()
                ->map(fn($c) => ['value' => $c->id, 'text' => $c->name])
                ->toArray();
        });
    }

    public function getLanguagesProperty()
    {
        return cache()->remember('languages_options', 3600, function() {
            return Language::orderBy('name')
                ->get()
                ->map(fn($l) => ['value' => $l->id, 'text' => $l->name])
                ->toArray();
        });
    }

    public function getAwardNamesProperty()
    {
        return cache()->remember('award_names', 3600, function() {
            $predefinedAwards = [
                'Oscar',
                'Golden Globe',
                'BAFTA',
                'Cannes Film Festival',
                'Berlin International Film Festival',
                'Venice Film Festival'
            ];

            $dbAwards = Award::select('name')
                ->distinct()
                ->orderBy('name')
                ->pluck('name')
                ->toArray();

            $allAwards = array_unique(array_merge($predefinedAwards, $dbAwards));
            sort($allAwards);

            return array_map(fn($name) => ['value' => $name, 'text' => $name], $allAwards);
        });
    }

    public function mount(): void
    {
        $this->genres = Genre::orderBy('name')->get();
        $this->people = Person::orderBy('name')->get();
        $this->departments = Department::orderBy('name')->get();

        foreach (AgeRating::cases() as $case) {
            $this->ageRatingOptions[] = ['value' => $case->value, 'text' => $case->value];
        }

        $this->initializeCast();
        $this->initializeCrew();
        $this->initializeAwards();
    }

    public function save()
    {
        $this->form->validate();

        if (!$this->validateAwards()) {
            return;
        }


        try {
            $this->form->awardsData = $this->awardsData;

            $this->form->store($this->castData, $this->crewData);

            session()->flash('message', 'Film erfolgreich erstellt!');
            return $this->redirect('/movies');

        } catch (\Exception $e) {
            $this->addError('general', 'Fehler beim Speichern: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.movies.create-movie');
    }
}
