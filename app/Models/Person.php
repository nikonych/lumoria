<?php

namespace App\Models;

use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory;

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

    function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    function crewPositions(): BelongsToMany
    {
        return $this->belongsToMany(CrewPosition::class);
    }

    function awards(): BelongsToMany
    {
        return $this->belongsToMany(Award::class);
    }
}
