<?php

namespace App\Livewire\Forms;

use App\Enums\AgeRating;
use App\Models\Award;
use App\Models\AwardWinner;
use App\Models\Category;
use App\Models\CrewPosition;
use App\Models\Movie;
use App\Models\Person;
use App\Models\Role;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Rule;
use Livewire\Form;

class PersonForm extends Form
{
    public string $name = '';
    public string $description = '';
    public $profile_image;
    public ?int $nationality_id = null; // Changed from string to int (foreign key)
    public ?int $selectedLanguage_id = null;

    public array $departments = [];
    public array $selectedDepartments = [];
    public string $birth_date = '';
    public string $death_date = '';
    public string $birth_place = '';

    public array $awardsData = [];
    public string $biography = '';
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

    public function rules($isUpdate = false): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|min:10',
            'nationality_id' => 'nullable|exists:countries,id',
//            'selectedLanguages' => 'nullable|array',
//            'selectedLanguages.*' => 'exists:languages,id',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date|after:birth_date',
            'birth_place' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'selectedDepartments' => 'nullable|array',
            'selectedDepartments.*' => 'exists:departments,id',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'cast' => 'nullable|array',
            'crew' => 'nullable|array',
            'awardsData' => 'nullable|array',
        ];

        if ($isUpdate) {
            $rules['profile_image'] = 'nullable';
        } else {
            $rules['profile_image'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        return $rules;
    }

    public function store(): void
    {
        try {
            DB::beginTransaction();

            $person = Person::create([
                'name' => $this->name,
                'description' => $this->description,
                'nationality_id' => $this->nationality_id,
                'birth_date' => $this->birth_date ?: null,
                'death_date' => $this->death_date ?: null,
                'birth_place' => $this->birth_place,
                'biography' => $this->biography,
            ]);

            // Handle profile image upload
            if ($this->profile_image) {
                $person->update([
                    'profile_image' => $this->profile_image->store('profiles', 'public')
                ]);
            }

            // Attach languages
//            if (!empty($this->selectedLanguages)) {
//                $person->languages()->attach($this->selectedLanguages);
//            }

            // Attach departments
            if (!empty($this->selectedDepartments)) {
                $person->departments()->attach($this->selectedDepartments);
            }

            // Handle photo gallery uploads
            if (!empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    $path = $photo->store('persons/' . $person->id . '/gallery', 'public');
                    $person->photos()->create([
                        'file_path' => $path,
                    ]);
                }
            }

            // Handle cast roles (movies where this person acted)
            if (!empty($this->cast)) {
                foreach ($this->cast as $role) {
                    if (!empty($role['movie_id']) && !empty($role['role_name'])) {
                        Role::create([
                            'movie_id' => $role['movie_id'],
                            'person_id' => $person->id,
                            'name' => $role['role_name'],
                        ]);
                    }
                }
            }

            // Handle crew positions (movies where this person worked as crew)
            if (!empty($this->crew)) {
                foreach ($this->crew as $crewMember) {
                    if (!empty($crewMember['movie_id']) && !empty($crewMember['department_id']) && !empty($crewMember['position'])) {
                        CrewPosition::create([
                            'movie_id' => $crewMember['movie_id'],
                            'person_id' => $person->id,
                            'department_id' => $crewMember['department_id'],
                            'position' => $crewMember['position'],
                        ]);
                    }
                }
            }

            // Handle awards
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
                                    'person_id' => $person->id,
                                    'movie_id' => !empty($categoryData['movie_id']) ? $categoryData['movie_id'] : null,
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();

        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();
            throw $e; // Re-throw the exception to handle it in the calling code
        }
    }

    public function update(Person $person): void
    {
        try {
            DB::beginTransaction();

            $person->update([
                'name' => $this->name,
                'description' => $this->description,
                'nationality_id' => $this->nationality_id,
                'birth_date' => $this->birth_date ?: null,
                'death_date' => $this->death_date ?: null,
                'birth_place' => $this->birth_place,
                'biography' => $this->biography,
            ]);

            if ($this->profile_image && is_object($this->profile_image) && method_exists($this->profile_image, 'store')) {
                if ($person->profile_image) {
                    Storage::disk('public')->delete($person->profile_image);
                }
                $person->update([
                    'profile_image' => $this->profile_image->store('profiles', 'public')
                ]);
            }

            // Sync languages
//            $person->languages()->sync($this->selectedLanguages);

            // Sync departments
            $person->departments()->sync($this->selectedDepartments);

            // Handle deleted photos
            if (!empty($this->deletedPhotos)) {
                foreach ($this->deletedPhotos as $photoId) {
                    $photo = $person->photos()->find($photoId);
                    if ($photo) {
                        Storage::disk('public')->delete($photo->file_path);
                        $photo->delete();
                    }
                }
            }

            // Handle new photo uploads
            if (!empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    $path = $photo->store('persons/' . $person->id . '/gallery', 'public');
                    $person->photos()->create([
                        'file_path' => $path,
                    ]);
                }
            }


            $syncData = [];
            if (!empty($this->cast)) {
                foreach ($this->cast as $actor) {
                    if (!empty($actor['movie_id']) && !empty($actor['role_name'])) {
                        $syncData[$actor['movie_id']] = ['name' => $actor['role_name']];
                    }
                }
            }
            $person->actedMovies()->sync($syncData);


            $syncData = [];
            if (!empty($this->crew)) {
                foreach ($this->crew as $member) {
                    if (!empty($member['movie_id']) && !empty($member['department_id']) && !empty($member['position'])) {
                        $syncData[$member['movie_id']] = [
                            'department_id' => $member['department_id'],
                            'position' => $member['position']
                        ];
                    }
                }
            }
            $person->crew()->sync($syncData);

            AwardWinner::where('person_id', $person->id)->delete();
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
                                    'person_id' => $person->id,
                                    'movie_id' => !empty($categoryData['movie_id']) ? $categoryData['movie_id'] : null,
                                ]);
                            }
                        }
                    }
                }
            }


            DB::commit();
            ActivityLogger::logPersonCreated(auth()->user(), $person);


        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
