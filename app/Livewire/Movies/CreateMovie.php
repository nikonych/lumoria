<?php

namespace App\Livewire\Movies;

use App\Enums\AgeRating;
use App\Livewire\Forms\MovieForm;
use App\Livewire\Traits\CreateMovie\ManagesAwards;
use App\Livewire\Traits\CreateMovie\ManagesCast;
use App\Livewire\Traits\CreateMovie\ManagesCrew;
use App\Models\Award;
use App\Models\Category;
use App\Models\Country;
use App\Models\Department;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Person;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateMovie extends Component
{
    use WithFileUploads;
    use ManagesCast, ManagesCrew, ManagesAwards;

    public MovieForm $form;

    public array $photos = [];

    public array $cast = [];
    public int $castCounter = 0;
    public array $crew = [];
    public int $crewCounter = 0;

    public array $awardsData = [];

    public int $awardCounter = 0;
    public int $categoryCounter = 0;
    public array $ageRatingOptions = [];

    protected $listeners = ['photosUpdated' => 'handlePhotosUpdate', 'optionsUpdated' => 'refreshOptions'];


    public function refreshOptions(string $modelClass): void
    {

        if ($modelClass === Person::class) {
            $this->dispatch('updatePeopleOptions',
                options: $this->people,
                modelClass: $modelClass
            );
        }

    }

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
    #[Computed]
    public function countries()
    {
        return Country::orderBy('name')
            ->get()
            ->map(fn($c) => ['value' => $c->id, 'text' => $c->name])
            ->toArray();
    }

    #[Computed]
    public function languages()
    {
        return Language::orderBy('name')
            ->get()
            ->map(fn($c) => ['value' => $c->id, 'text' => $c->name])
            ->toArray();
    }

    #[Computed]
    public function departments()
    {
        return Department::orderBy('name')
            ->get()
            ->map(fn($c) => ['value' => $c->id, 'text' => $c->name])
            ->toArray();
    }

    #[Computed]
    public function genres()
    {
        return Genre::orderBy('name')
            ->get();
    }

    #[Computed]
    public function people()
    {
        return Person::orderBy('name')
            ->get()
            ->map(fn($c) => ['value' => $c->id, 'text' => $c->name])
            ->toArray();
    }

    #[Computed]
    public function awardOptions()
    {
        return Award::orderBy('name')
            ->get()
            ->unique('name')
            ->map(fn($c) => ['value' => $c->name, 'text' => $c->name])
            ->toArray();
    }

    #[Computed]
    public function categoryOptions()
    {
        return Category::orderBy('name')
            ->get()
            ->unique('name')
            ->map(fn($c) => ['value' => $c->name, 'text' => $c->name])
            ->toArray();
    }


    public function mount(): void
    {

        $this->castCounter = 0;

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

        try {

            $this->form->store();

            return $this->redirect('/movies/all');

        } catch (\Exception $e) {
            $this->addError('general', 'Fehler beim Speichern: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.movies.create-movie');
    }
}
