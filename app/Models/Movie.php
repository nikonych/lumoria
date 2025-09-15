<?php

namespace App\Models;

use Database\Factories\MovieFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property string|null $original_title
 * @property string|null $release_year
 * @property string|null $duration_minutes
 * @property string|null $age_rating
 * @property string|null $description
 * @property string|null $trailer_url
 * @property string|null $poster_image
 * @property string $rating
 * @property int|null $country_id
 * @property int|null $language_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Person> $actors
 * @property-read int|null $actors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AwardWinner> $awards
 * @property-read int|null $awards_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Person> $crew
 * @property-read int|null $crew_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Genre> $genres
 * @property-read int|null $genres_count
 * @property-read float $average_rating
 * @property-read string $formatted_rating
 * @property-read string $formatted_reviews_count
 * @property-read \App\Models\Language|null $language
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Person> $people
 * @property-read int|null $people_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Photo> $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @method static \Database\Factories\MovieFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereAgeRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereOriginalTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie wherePosterImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereReleaseYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereTrailerUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie withoutTrashed()
 * @mixin \Eloquent
 */
class Movie extends Model
{
    /** @use HasFactory<MovieFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'original_title',
        'release_year',
        'duration_minutes',
        'age_rating',
        'description',
        'trailer_url',
        'poster_image',
        'rating'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
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
            ->withPivot('position');
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
