<?php

namespace App\Livewire\Forms;

use App\Enums\AgeRating;
use App\Models\Award;
use App\Models\AwardWinner;
use App\Models\Category;
use App\Models\CrewPosition;
use App\Models\Movie;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Rule;
use Livewire\Form;

class MovieForm extends Form
{
    #[Rule('required|string|max:255')]
    public string $title = '';

    #[Rule('nullable|string|max:255')]
    public string $original_title = '';

    #[Rule('nullable|exists:countries,id')]
    public ?int $original_country_id = null;

    #[Rule('nullable|exists:languages,id')]
    public ?int $original_language_id = null;

    #[Rule('nullable|integer')]
    public ?int $release_year = null;

    #[Rule('nullable|integer')]
    public ?int $duration_minutes = null;

    #[Rule(['nullable', new Enum(AgeRating::class)])]
    public ?string $age_rating = null;

    #[Rule('nullable|url')]
    public string $trailer_url = '';

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('nullable|array')]
    public array $selectedGenres = [];

    #[Rule('nullable|array')]
    public array $awardsData = [];

    #[Rule('nullable|image|max:1024')]
    public $poster_image;

    #[Rule([
        'photos' => 'nullable|array',
        'photos.*' => 'image',
    ])]
    public array $photos = [];

    #[Rule('nullable|array')]
    public $cast = [];

    #[Rule('nullable|array')]
    public $crew = [];

    public function store(): void
    {
        try {
            DB::beginTransaction();

            $movie = Movie::create([
                'title' => $this->title,
                'original_title' => $this->original_title,
                'release_year' => $this->release_year,
                'original_country_id' => $this->original_country_id,
                'original_language_id' => $this->original_language_id,
                'duration_minutes' => $this->duration_minutes,
                'age_rating' => $this->age_rating,
                'trailer_url' => $this->trailer_url,
                'description' => $this->description,
            ]);

            if (!empty($this->selectedGenres)) {
                $movie->genres()->attach($this->selectedGenres);
            }

            if ($this->poster_image) {
                $movie->update([
                    'poster_image' => $this->poster_image->store('posters', 'public')
                ]);
            }

            if (!empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    $path = $photo->store('movies/'. $movie->id .'/gallery', 'public');
                    $movie->photos()->create([
                        'file_path' => $path,
                    ]);
                }
            }

            if (!empty($this->cast)) {
                foreach ($this->cast as $actor) {
                    if (!empty($actor['person_id']) && !empty($actor['role_name'])) {
                        Role::create([
                            'movie_id' => $movie->id,
                            'person_id' => $actor['person_id'],
                            'name' => $actor['role_name'],
                        ]);
                    }
                }
            }

            if (!empty($this->crew)) {
                foreach ($this->crew as $member) {
                    if (!empty($member['person_id']) && !empty($member['department_id']) && !empty($member['position'])) {
                        CrewPosition::create([
                            'movie_id' => $movie->id,
                            'person_id' => $member['person_id'],
                            'department_id' => $member['department_id'],
                            'position' => $member['position'],
                        ]);
                    }
                }
            }

            if (!empty($this->awardsData)) {
                foreach ($this->awardsData as $awardData) {
                    if (!empty($awardData['award_name']) && !empty($awardData['categories'])) {
                        foreach ($awardData['categories'] as $categoryData) {
                            if (!empty($categoryData['category'])) {
                                $award = Award::firstOrCreate([
                                    'name' => $awardData['award_name']
                                ]);

                                $category = Category::firstOrCreate([
                                    'name' => $categoryData['category']
                                ]);

                                AwardWinner::create([
                                    'award_id' => $award->id,
                                    'category_id' => $category->id,
                                    'movie_id' => $movie->id,
                                    'person_id' => !empty($categoryData['person_id']) ? $categoryData['person_id'] : null,
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();


        }  catch (\Throwable $e) {
            DB::rollBack();



        }
    }

    public function update(Movie $movie): void
    {
        DB::transaction(function () use ($movie) {
            $movie->update([
                'title' => $this->title,
                'original_title' => $this->original_title,
                'release_year' => $this->release_year,
                'original_country_id' => $this->original_country_id,
                'original_language_id' => $this->original_language_id,
                'duration_minutes' => $this->duration_minutes,
                'age_rating' => $this->age_rating,
                'trailer_url' => $this->trailer_url,
                'description' => $this->description,
            ]);

            // Обновляем жанры
            if (!empty($this->selectedGenres)) {
                $movie->genres()->sync($this->selectedGenres);
            } else {
                $movie->genres()->detach();
            }

            // Обновляем постер
            if ($this->poster_image) {
                // Удаляем старый постер
                if ($movie->poster_image) {
                    Storage::disk('public')->delete($movie->poster_image);
                }
                $movie->update([
                    'poster_image' => $this->poster_image->store('posters', 'public')
                ]);
            }

            // Обновляем фото (удаляем старые и добавляем новые)
            if (!empty($this->photos)) {
                // Удаляем старые фото
                foreach ($movie->photos as $photo) {
                    Storage::disk('public')->delete($photo->file_path);
                    $photo->delete();
                }

                // Добавляем новые
                foreach ($this->photos as $photo) {
                    if (is_uploaded_file($photo->getRealPath())) {
                        $path = $photo->store("movies/{$movie->id}/gallery", 'public');
                        $movie->photos()->create([
                            'file_path' => $path,
                        ]);
                    }
                }
            }

            // Обновляем каст
            $movie->roles()->delete(); // Удаляем старые роли
            if (!empty($this->cast)) {
                foreach ($this->cast as $actor) {
                    if (!empty($actor['person_id']) && !empty($actor['role_name'])) {
                        Role::create([
                            'movie_id' => $movie->id,
                            'person_id' => $actor['person_id'],
                            'name' => $actor['role_name'],
                        ]);
                    }
                }
            }

            // Обновляем команду
            $movie->crewPositions()->delete();
            if (!empty($this->crew)) {
                foreach ($this->crew as $member) {
                    if (!empty($member['person_id']) && !empty($member['department_id']) && !empty($member['position'])) {
                        CrewPosition::create([
                            'movie_id' => $movie->id,
                            'person_id' => $member['person_id'],
                            'department_id' => $member['department_id'],
                            'position' => $member['position'],
                        ]);
                    }
                }
            }

            // Обновляем награды
            $movie->awardWinners()->delete();
            if (!empty($this->awardsData)) {
                foreach ($this->awardsData as $awardData) {
                    if (!empty($awardData['award_name']) && !empty($awardData['categories'])) {
                        foreach ($awardData['categories'] as $categoryData) {
                            if (!empty($categoryData['category'])) {
                                $award = Award::firstOrCreate([
                                    'name' => $awardData['award_name']
                                ]);

                                $category = Category::firstOrCreate([
                                    'name' => $categoryData['category']
                                ]);

                                AwardWinner::create([
                                    'award_id' => $award->id,
                                    'category_id' => $category->id,
                                    'movie_id' => $movie->id,
                                    'person_id' => !empty($categoryData['person_id']) ? $categoryData['person_id'] : null,
                                ]);
                            }
                        }
                    }
                }
            }
        });
    }
}
