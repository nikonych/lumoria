<?php

namespace App\Livewire\Forms;

use App\Enums\AgeRating;
use App\Models\Award;
use App\Models\AwardWinner;
use App\Models\Category;
use App\Models\CrewPosition;
use App\Models\Movie;
use App\Models\Role;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Rule;
use Livewire\Form;

class MovieForm extends Form
{
    public string $title = '';

    public string $original_title = '';

    public ?int $original_country_id = null;

    public ?int $original_language_id = null;

    public ?int $release_year = null;

    public ?int $duration_minutes = null;

    public ?string $age_rating = null;

    public string $trailer_url = '';

    public string $description = '';

    public array $selectedGenres = [];

    public array $awardsData = [];

    public $poster_image;


    public array $photos = [];

    public $cast = [];

    public $crew = [];

    public array $deletedPhotos = [];

    public function validateForCreate(): void
    {
        $this->validate($this->rules(false));
    }

    public function validateForUpdate(): void
    {
        $this->validate($this->rules(true));
    }

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
                    $path = $photo->store('movies/' . $movie->id . '/gallery', 'public');
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
            ActivityLogger::logMovieCreated(auth()->user(), $movie);




        } catch (\Throwable $e) {
            DB::rollBack();


        }
    }

    public function rules($isUpdate = false): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'original_title' => 'nullable|string|max:255',
            'original_country_id' => 'nullable|exists:countries,id',
            'original_language_id' => 'nullable|exists:languages,id',
            'release_year' => 'nullable|integer|min:1900',
            'duration_minutes' => 'nullable|integer|min:1|max:500',
            'age_rating' => 'nullable|string',
            'trailer_url' => 'nullable|url',
            'description' => 'nullable|string|min:10',
            'selectedGenres' => 'nullable|array',
            'selectedGenres.*' => 'exists:genres,id',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'cast' => 'nullable|array',
            'crew' => 'nullable|array',
            'awardsData' => 'nullable|array',
        ];

        if ($isUpdate) {
            $rules['poster_image'] = 'nullable';
        } else {
            $rules['poster_image'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        return $rules;
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

            if (!empty($this->selectedGenres)) {
                $movie->genres()->sync($this->selectedGenres);
            } else {
                $movie->genres()->detach();
            }

            if ($this->poster_image && is_object($this->poster_image) && method_exists($this->poster_image, 'store')) {
                if ($movie->poster_image) {
                    Storage::disk('public')->delete($movie->poster_image);
                }
                $movie->update([
                    'poster_image' => $this->poster_image->store('posters', 'public')
                ]);
            }

            if (!empty($this->deletedPhotos)) {
                foreach ($this->deletedPhotos as $photoPath) {
                    $photoRecord = $movie->photos()->where('file_path', $photoPath)->first();
                    if ($photoRecord) {
                        if (Storage::disk('public')->exists($photoPath)) {
                            Storage::disk('public')->delete($photoPath);
                        }
                        $photoRecord->delete();
                    }
                }
            }

            if (!empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    if (is_object($photo) && method_exists($photo, 'store')) {
                        $path = $photo->store("movies/{$movie->id}/gallery", 'public');
                        $movie->photos()->create([
                            'file_path' => $path,
                        ]);
                    }
                }
            }


            $syncData = [];
            if (!empty($this->cast)) {
                foreach ($this->cast as $actor) {
                    if (!empty($actor['person_id']) && !empty($actor['role_name'])) {
                        $syncData[$actor['person_id']] = ['name' => $actor['role_name']];
                    }
                }
            }
            $movie->actors()->sync($syncData);

            $syncData = [];
            if (!empty($this->crew)) {
                foreach ($this->crew as $member) {
                    if (!empty($member['person_id']) && !empty($member['department_id']) && !empty($member['position'])) {
                        $syncData[$member['person_id']] = [
                            'department_id' => $member['department_id'],
                            'position' => $member['position']
                        ];
                    }
                }
            }
            $movie->crew()->sync($syncData);

            AwardWinner::where('movie_id', $movie->id)->delete();

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
