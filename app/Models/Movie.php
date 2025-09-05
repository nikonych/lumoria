<?php

namespace App\Models;

use Database\Factories\MovieFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Movie extends Model
{
    /** @use HasFactory<MovieFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'original_title',
        'release_year',
        'duration_minutes',
        'age_rating',
        'description',
        'trailer_url',
        'poster_image'
    ];

    protected function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    protected function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    protected function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    protected function language(): HasOne
    {
        return $this->hasOne(Language::class);
    }

    protected function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    protected function awards(): HasMany
    {
        return $this->hasMany(Award::class);
    }

    protected function ratings(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'roles');
    }

    public function crew(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'crew_positions');
    }
}
