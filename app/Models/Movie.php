<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\MovieFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    /** @use HasFactory<MovieFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


    protected $fillable = [
        'title',
        'original_title',
        'release_year',
        'duration_minutes',
        'age_rating',
        'description',
        'trailer_url',
        'poster_image',
        'rating',
        'original_country_id',
        'original_language_id',
    ];

    public function originalCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'original_country_id');
    }

    public function originalLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'original_language_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'original_country_id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'original_language_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function crewPositions(): HasMany
    {
        return $this->hasMany(CrewPosition::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }


    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    public function awards(): HasMany
    {
        return $this->hasMany(AwardWinner::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'roles')
            ->withPivot('name')
            ->withTimestamps();
    }

    public function crew(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'crew_positions')
            ->withPivot(['position', 'department_id'])
            ->withTimestamps();
    }

    public function getPosterUrlAttribute(): ?string
    {
        if (!$this->poster_image) {
            return null;
        }

        if (str_starts_with($this->poster_image, 'http')) {
            return $this->poster_image;
        }

        return Storage::url($this->poster_image);
    }

    public function getPosterUrlWithFallbackAttribute(): string
    {
        return $this->poster_url ?? asset('images/no-poster.jpg');
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews_avg_rating ?? 0;
    }

    public function getFormattedRatingAttribute(): string
    {
        return number_format($this->average_rating, 1);
    }

    public function getFormattedReviewsCountAttribute(): string
    {
        return number_format($this->reviews_count ?? 0);
    }

    public function hasReviews(): bool
    {
        return ($this->reviews_count ?? 0) > 0;
    }
}
