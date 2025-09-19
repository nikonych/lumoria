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

    protected $listeners = ['photosUpdated' => 'handlePhotosUpdate', 'optionsUpdated' => 'refreshOptions'];

    public function mount(Movie $movie)
    {
        $this->movie = $movie;
        $this->loadMovieData();
        $this->initializeOptions();
    }

    protected function loadMovieData()
    {
        // Загружаем данные фильма в форму
        $this->form->title = $this->movie->title;
        $this->form->original_title = $this->movie->original_title ?? '';
        $this->form->original_country_id = $this->movie->original_country_id;
        $this->form->original_language_id = $this->movie->original_language_id;
        $this->form->release_year = $this->movie->release_year;
        $this->form->duration_minutes = $this->movie->duration_minutes;
        $this->form->age_rating = $this->movie->age_rating;
        $this->form->trailer_url = $this->movie->trailer_url ?? '';
        $this->form->description = $this->movie->description ?? '';

        // Загружаем жанры
        $this->form->selectedGenres = $this->movie->genres->pluck('id')->toArray();

        // Загружаем каст
        $this->cast = $this->movie->roles->map(function($role) {
            return [
                'id' => $role->id,
                'person_id' => $role->person_id,
                'role_name' => $role->name,
            ];
        })->toArray();

        // Загружаем команду
        $this->crew = $this->movie->crewPositions->map(function($position) {
            return [
                'id' => $position->id,
                'person_id' => $position->person_id,
                'department_id' => $position->department_id,
                'position' => $position->position,
            ];
        })->toArray();

        // Загружаем награды
        if(!empty($this->movie->awardWinners)) {
            $this->awardsData = $this->movie->awardWinners->groupBy('award.name')->map(function ($winners, $awardName) {
                return [
                    'id' => uniqid(),
                    'award_name' => $awardName,
                    'categories' => $winners->map(function ($winner) {
                        return [
                            'id' => $winner->id,
                            'category' => $winner->category->name,
                            'person_id' => $winner->person_id,
                        ];
                    })->toArray()
                ];
            })->values()->toArray();
        }

        // Загружаем фото
        $this->photos = $this->movie->photos->map(function($photo) {
            return $photo->file_path;
        })->toArray();

        $this->form->photos = $this->photos;
        $this->form->cast = $this->cast;
        $this->form->crew = $this->crew;
        $this->form->awardsData = $this->awardsData;
    }

    protected function initializeOptions()
    {
        foreach (AgeRating::cases() as $case) {
            $this->ageRatingOptions[] = ['value' => $case->value, 'text' => $case->value];
        }
    }

    // Остальные методы такие же как в CreateMovie...
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
        $this->form->validate();

        try {
            $this->form->update($this->movie);

            session()->flash('success', 'Film erfolgreich aktualisiert!');
            return redirect()->route('movies.show', $this->movie);

        } catch (\Exception $e) {
            $this->addError('general', 'Fehler beim Speichern: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.movies.edit-movie');
    }
}
