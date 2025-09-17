<?php

namespace App\Livewire\Forms;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Form;

class MovieForm extends Form
{
    #[Rule('required|string|max:255')]
    public string $title = '';

    #[Rule('nullable|string|max:255')]
    public string $original_title = '';

    #[Rule('nullable|integer|min:1888')]
    public ?int $release_year = null;

    #[Rule('nullable|integer|min:1')]
    public ?int $duration_minutes = null;

    #[Rule('nullable|string|max:10')]
    public string $age_rating = '';

    #[Rule('nullable|url')]
    public string $trailer_url = '';

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('required|array|min:1')]
    public array $selectedGenres = [];

    // УБИРАЕМ ВСЮ ВАЛИДАЦИЮ для cast и crew
    public array $awards = [];

    #[Rule('nullable|image|max:1024')]
    public $poster;

    public function store(array $castData, array $crewData): void
    {

        $this->validate();

        DB::transaction(function () use ($castData, $crewData) {
            $movie = Movie::create([
                'title' => $this->title,
                'original_title' => $this->original_title,
                'release_year' => $this->release_year,
                'duration_minutes' => $this->duration_minutes,
                'age_rating' => $this->age_rating,
                'trailer_url' => $this->trailer_url,
                'description' => $this->description,
            ]);

            $movie->genres()->attach($this->selectedGenres);

            if ($this->poster) {
                $movie->update([
                    'poster_image' => $this->poster->store('posters', 'public')
                ]);
            }

            foreach ($castData as $actor) {
                if (!empty($actor['person_id']) && !empty($actor['role_name'])) {
                    $movie->roles()->create([
                        'person_id' => $actor['person_id'],
                        'name' => $actor['role_name'],
                    ]);
                }
            }

            // Используем переданные данные
            foreach ($crewData as $member) {
                if (!empty($member['person_id']) && !empty($member['department_id']) && !empty($member['position'])) {
                    $movie->crew()->create([
                        'person_id' => $member['person_id'],
                        'department_id' => $member['department_id'],
                        'position' => $member['position'],
                    ]);
                }
            }
        });
    }
}
