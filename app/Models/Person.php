<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


    protected $fillable = [
        'name',
        'birth_date',
        'death_date',
        'birth_place',
        'biography',
        'nationality_id',
        'profile_image',
        'description',
    ];

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class);
    }

    function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    function crewPositions(): BelongsToMany
    {
        return $this->belongsToMany(CrewPosition::class);
    }

    public function awards(): HasMany
    {
        return $this->hasMany(AwardWinner::class);
    }

    public function actedMovies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'roles')
            ->withPivot('name')
            ->withTimestamps();
    }

    public function crew(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'crew_positions')
            ->withPivot(['position', 'department_id'])
            ->withTimestamps();
    }

    public function moviesGroupedByDepartment(): Attribute
    {
        return Attribute::make(
            get: function () {
                $departments = $this->departments()->get();

                $departments->each(function ($department) {
                    $department->movies = Movie::whereHas('crew', function ($query) use ($department) {
                        $query->where('person_id', $this->id)
                            ->whereHas('departments', function ($subQuery) use ($department) {
                                $subQuery->where('departments.id', $department->id);
                            });
                    })->limit(3)->get();
                });

                return $departments;
            }
        );
    }

    protected function awardsGroupedByName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->awards()
                ->with(['movie', 'award'])
                ->get()
                ->groupBy('award.name')
        );
    }

    public function getProfileUrlAttribute(): ?string
    {
        if (!$this->profile_image) {
            return null;
        }

        if (str_starts_with($this->profile_image, 'http')) {
            return $this->profile_image;
        }

        return Storage::url($this->profile_image);
    }

    public function getNationalityNameAttribute(): ?string
    {
        return $this->nationality?->name;
    }

    public function getLanguagesListAttribute(): array
    {
        return $this->languages->pluck('name')->toArray();
    }
}
