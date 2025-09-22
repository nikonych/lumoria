<?php

namespace App\Livewire\Movies;

use App\Enums\AgeRating;
use App\Livewire\Forms\MovieForm;
use App\Livewire\Traits\CreateMovie\ManagesAwards;
use App\Livewire\Traits\CreateMovie\ManagesCast;
use App\Livewire\Traits\CreateMovie\ManagesCrew;
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

class EditMovie extends Component
{
    use WithFileUploads;
    use ManagesCast, ManagesCrew, ManagesAwards;

    public Movie $movie;
    public MovieForm $form;
    public array $photos = [];
    public array $cast = [];
    public array $crew = [];
    public array $awardsData = [];
    public array $ageRatingOptions = [];

    public array $existingPhotos = [];
    public array $newPhotos = [];
    public array $deletedPhotos = [];

    public int $castCounter = 0;
    public int $crewCounter = 0;

    public int $awardCounter = 0;
    public int $categoryCounter = 0;

    protected $listeners = ['photosUpdated' => 'handlePhotosUpdate', 'optionsUpdated' => 'refreshOptions'];

    public function mount(Movie $movie)
    {
        $this->movie = $movie;
        $this->loadMovieData();
        $this->initializeOptions();

        $this->initializeCast();
        $this->initializeCrew();
        $this->initializeAwards();

    }

    protected function loadMovieData()
    {
        $this->form->title = $this->movie->title;
        $this->form->original_title = $this->movie->original_title ?? '';
        $this->form->original_country_id = $this->movie->original_country_id;
        $this->form->original_language_id = $this->movie->original_language_id;
        $this->form->release_year = $this->movie->release_year;
        $this->form->duration_minutes = $this->movie->duration_minutes;
        $this->form->age_rating = $this->movie->age_rating;
        $this->form->trailer_url = $this->movie->trailer_url ?? '';
        $this->form->description = $this->movie->description ?? '';
        $this->form->poster_image = $this->movie->poster_image;

        $this->form->selectedGenres = $this->movie->genres->pluck('id')->toArray();
        $this->cast = $this->movie->actors->map(function($person, $index) {
            return [
                'id' => $index,
                'person_id' => (string)$person->id,
                'role_name' => $person->pivot->name,
            ];
        })->toArray();
        $this->form->cast = $this->cast;




        $this->crew = $this->movie->crew->map(function($person, $index) {
            return [
                'id' => $index,
                'person_id' => (string)$person->id,
                'department_id' => (string)$person->pivot->department_id,
                'position' => $person->pivot->position,
            ];
        })->toArray();
        $this->form->crew = $this->crew;

        $this->awardsData = AwardWinner::where('movie_id', $this->movie->id)
            ->with(['award', 'person', 'category'])
            ->get()
            ->toArray(); // Convert to array immediately

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
                                'person_id' => $winner['person_id'] ? (string)$winner['person_id'] : '',
                            ];
                        })->toArray()
                    ];
                })
                ->values()
                ->toArray();
        }
        $this->form->awardsData = $this->awardsData;

        // Загружаем фото
        $this->existingPhotos = $this->movie->photos->pluck('file_path')->toArray();
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
        foreach (AgeRating::cases() as $case) {
            $this->ageRatingOptions[] = ['value' => $case->value, 'text' => $case->value];
        }
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


            $this->form->update($this->movie);

            session()->flash('success', 'Film erfolgreich aktualisiert!');
            return redirect()->route('movies.details', $this->movie);

        } catch (\Exception $e) {
            dd($e);
            $this->addError('general', 'Fehler beim Speichern: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.movies.edit-movie');
    }
}
