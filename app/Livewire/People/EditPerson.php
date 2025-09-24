<?php

namespace App\Livewire\People;

use App\Enums\AgeRating;
use App\Livewire\Forms\PersonForm;
use App\Livewire\Traits\CreatePerson\ManagesAwards;
use App\Livewire\Traits\CreatePerson\ManagesCast;
use App\Livewire\Traits\CreatePerson\ManagesCrew;
use App\Models\Award;
use App\Models\AwardWinner;
use App\Models\Category;
use App\Models\Country;
use App\Models\Department;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\Person;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPerson extends Component
{
    use WithFileUploads;
    use ManagesCast, ManagesCrew, ManagesAwards;

    public PersonForm $form;
    public Person $person;
    public array $photos = [];
    public array $cast = [];
    public array $crew = [];
    public array $awardsData = [];
    public array $existingPhotos = [];
    public array $newPhotos = [];
    public array $deletedPhotos = [];

    public int $castCounter = 0;
    public int $crewCounter = 0;

    public int $awardCounter = 0;
    public int $categoryCounter = 0;

    protected $listeners = ['photosUpdated' => 'handlePhotosUpdate', 'optionsUpdated' => 'refreshOptions'];

    public function mount(Person $person)
    {
        $this->person = $person;
        $this->loadPersonData();
        $this->initializeOptions();

        $this->initializeCast();
        $this->initializeCrew();
        $this->initializeAwards();

    }

    protected function loadPersonData()
    {
        $this->form->name = $this->person->name;
        $this->form->description = $this->person->description ?? '';
        $this->form->profile_image = $this->person->profile_image;
        $this->form->birth_date = $this->person->birth_date ?? '';
        $this->form->death_date = $this->person->death_date ?? '';
        $this->form->nationality_id = $this->person->nationality->id ?? null;
        $this->form->biography = $this->person->biography ?? '';
        $this->form->birth_place = $this->person->birth_place ?? '';

        $this->form->selectedDepartments = $this->person->departments->pluck('id')->toArray();

        $this->cast = $this->person->actedMovies->map(function($movie, $index) {
            return [
                'id' => $index,
                'movie_id' => (string)$movie->id,
                'role_name' => $movie->pivot->name,
            ];
        })->toArray();
        $this->form->cast = $this->cast;




        $this->crew = $this->person->crew->map(function($movie, $index) {
            return [
                'id' => $index,
                'movie_id' => (string)$movie->id,
                'department_id' => (string)$movie->pivot->department_id,
                'position' => $movie->pivot->position,
            ];
        })->toArray();
        $this->form->crew = $this->crew;

        $this->awardsData = AwardWinner::where('person_id', $this->person->id)
            ->with(['award', 'movie', 'category'])
            ->get()
            ->toArray();
        if(!empty($this->awardsData)) {
            $this->awardsData = collect($this->awardsData) // Convert back to collection for processing
            ->groupBy('award.name')
                ->map(function ($winners, $awardName) {
                    return [
                        'id' => $this->awardCounter++,
                        'award_name' => $awardName,
                        'categories' => collect($winners)->map(function ($winner) {
                            return [
                                'id' => $this->categoryCounter++,
                                'category' => $winner['category']['name'],
                                'movie_id' => $winner['movie_id'] ? (string)$winner['movie_id'] : '',
                            ];
                        })->toArray()
                    ];
                })
                ->values()
                ->toArray();
        }
        $this->form->awardsData = $this->awardsData;

        $this->existingPhotos = $this->person->photos->pluck('file_path')->toArray();
        $this->newPhotos = [];
        $this->castCounter = count($this->cast);
        $this->crewCounter = count($this->crew);
        $this->awardCounter = count($this->awardsData);

    }

    protected function initializeCastFromData()
    {
        if (empty($this->cast)) {
            $this->addCastMember();
        }
    }

    protected function initializeCrewFromData()
    {
        if (empty($this->crew)) {
            $this->addCrewMember();
        }
    }

    protected function initializeAwardsFromData()
    {
        if (empty($this->awardsData)) {
            $this->addAward();
        }
    }

    public function updatedNewPhotos(): void
    {
        $this->validateOnly('newPhotos', [
            'newPhotos' => 'nullable|array|max:10',
            'newPhotos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $this->form->photos = $this->newPhotos;
    }

    public function removePhoto($index): void
    {
        $existingCount = count($this->existingPhotos);

        if ($index < $existingCount) {
            $deletedPhoto = $this->existingPhotos[$index];
            $this->deletedPhotos[] = $deletedPhoto;

            unset($this->existingPhotos[$index]);
            $this->existingPhotos = array_values($this->existingPhotos);
        } else {
            $newIndex = $index - $existingCount;
            unset($this->newPhotos[$newIndex]);
            $this->newPhotos = array_values($this->newPhotos);
            $this->form->photos = $this->newPhotos;
        }
    }

    public function clearAllPhotos(): void
    {
        $this->deletedPhotos = array_merge($this->deletedPhotos, $this->existingPhotos);

        $this->existingPhotos = [];
        $this->newPhotos = [];
        $this->form->photos = [];
    }

    public function handlePhotosUpdate($photos): void
    {
        $this->newPhotos = $photos;
        $this->form->photos = $photos;
    }


    protected function initializeOptions(): void
    {

    }

    public function refreshOptions(string $modelClass): void
    {
        if ($modelClass === Person::class) {
            $this->dispatch('updatePeopleOptions',
                options: $this->people,
                modelClass: $modelClass
            );
        }
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
    public function movies()
    {
        return Movie::orderBy('title')
            ->get()
            ->map(fn($c) => ['value' => $c->id, 'text' => $c->title])
            ->toArray();
    }

    #[Computed]
    public function genres()
    {
        return Genre::orderBy('name')->get();
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

    public function save()
    {


        try {

            $this->form->validateForUpdate();

            $this->form->deletedPhotos = $this->deletedPhotos;


            $this->form->update($this->person);

            session()->flash('success', 'Person erfolgreich aktualisiert!');
            return redirect()->route('people.details', $this->person);

        } catch (\Exception $e) {
            dd($e);
            $this->addError('general', 'Fehler beim Speichern: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.people.edit-person');
    }
}
