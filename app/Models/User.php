<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'biography',
    ];

    public function settings(): HasOne
    {
        return $this->hasOne(UserNotificationSettings::Class);
    }

    public function favoriteGenres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'favorite_genre');
    }

    public function favoriteMovies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'favorite_movie');
    }

    public function favoritePeople(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'favorite_people');
    }

    public function watchlist(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'watchlist')->withTimestamps();
    }
    public function recommendations(): Builder
    {
        $favoriteGenreIds = $this->favoriteGenres()->pluck('genres.id');

        if ($favoriteGenreIds->isEmpty()) {
            return Movie::query()->whereRaw('1 = 0');
        }

        $favoriteMovieIds = $this->favoriteMovies()->pluck('movies.id');
        $watchlistMovieIds = $this->watchlist()->pluck('movies.id');
        $excludeMovieIds = $favoriteMovieIds->merge($watchlistMovieIds)->unique();

        return Movie::query()
            ->whereHas('genres', function (Builder $query) use ($favoriteGenreIds) {
                $query->whereIn('genres.id', $favoriteGenreIds);
            })
            ->whereNotIn('movies.id', $excludeMovieIds)
            ->orderByDesc('rating');
    }

    public function hasInFavorites(Movie $movie): bool
    {
        return $this->favoriteMovies()->where('movies.id', $movie->id)->exists();
    }

    public function hasMovieInCollection(Movie $movie): bool
    {
        return $this->collections()
            ->whereHas('movies', function($query) use ($movie) {
                $query->where('movies.id', $movie->id);
            })
            ->exists();
    }

    public function friends(): HasMany
    {
        return $this->hasMany(Friendship::class);
    }

    public function collections(): HasMany
    {
        return $this->hasMany(UserCollection::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Review::class);
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    public $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
