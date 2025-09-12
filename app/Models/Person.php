<?php

namespace App\Models;

use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'birth_date',
        'death_date',
        'birth_place',
        'biography',
        'nationality',
        'profile_image',
        'description',
    ];

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
}
