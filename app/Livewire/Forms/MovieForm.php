<?php

namespace App\Livewire\Forms;

use App\Enums\AgeRating;
use App\Models\Award;
use App\Models\AwardWinner;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Rule;
use Livewire\Form;

class MovieForm extends Form
{
    #[Rule('required|string|max:255')]
    public string $title = '';

    #[Rule('required|string|max:255')]
    public string $original_title = '';

    #[Rule('required|exists:countries,id')]
    public ?int $original_country_id = null;

    #[Rule('required|exists:languages,id')]
    public ?int $original_language_id = null;

    #[Rule('required|integer|min:1888')]
    public ?int $release_year = null;

    #[Rule('required|integer|min:1')]
    public ?int $duration_minutes = null;

    #[Rule(['required', new Enum(AgeRating::class)])]
    public ?AgeRating $age_rating = null;

    #[Rule('required|url')]
    public string $trailer_url = '';

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('required|array|min:1')]
    public array $selectedGenres = [];

    #[Rule([
        'awards' => 'nullable|array',
        'awards.*.award_name' => 'required|string',
        'awards.*.category' => 'required|string',
        'awards.*.person_ids' => 'nullable|array',
        'awards.*.person_ids.*' => 'exists:people,id',
    ])]
    public array $awards = [];

    #[Rule('required|image|max:1024')]
    public $poster_image;

    #[Rule([
        'photos' => 'required|array|min:1',
        'photos.*' => 'image',
    ])]
    public array $photos = [];

    public function store(array $castData, array $crewData): void
    {
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

            if ($this->poster_image) {
                $movie->update([
                    'poster_image' => $this->poster_image->store('posters', 'public')
                ]);
            }

            if (!empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    $path = $photo->store('movies/gallery', 'public');
                    $movie->photos()->create([
                        'path' => $path,
                        'original_name' => $photo->getClientOriginalName(),
                        'size' => $photo->getSize(),
                        'mime_type' => $photo->getMimeType(),
                    ]);
                }
            }

            foreach ($castData as $actor) {
                if (!empty($actor['person_id']) && !empty($actor['role_name'])) {
                    $movie->roles()->create([
                        'person_id' => $actor['person_id'],
                        'name' => $actor['role_name'],
                    ]);
                }
            }

            foreach ($crewData as $member) {
                if (!empty($member['person_id']) && !empty($member['department_id']) && !empty($member['position'])) {
                    $movie->crew()->create([
                        'person_id' => $member['person_id'],
                        'department_id' => $member['department_id'],
                        'position' => $member['position'],
                    ]);
                }
            }

            foreach ($this->awards as $awardData) {
                if (!empty($awardData['award_name']) && !empty($awardData['category'])) {
                    $award = Award::firstOrCreate(
                        [
                            'name' => $awardData['award_name'],
                            'category' => $awardData['category']
                        ]
                    );

                    AwardWinner::create([
                        'award_id' => $award->id,
                        'movie_id' => $movie->id,
                        'person_id' => null,
                    ]);

                    if (!empty($awardData['person_ids'])) {
                        foreach ($awardData['person_ids'] as $personId) {
                            AwardWinner::create([
                                'award_id' => $award->id,
                                'movie_id' => $movie->id,
                                'person_id' => $personId,
                            ]);
                        }
                    }
                }
            }
        });
    }
}
