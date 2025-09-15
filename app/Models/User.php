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
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $profile_image
 * @property string|null $biography
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserCollection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Genre> $favoriteGenres
 * @property-read int|null $favorite_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movie> $favoriteMovies
 * @property-read int|null $favorite_movies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Friendship> $friends
 * @property-read int|null $friends_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $ratings
 * @property-read int|null $ratings_count
 * @property-read \App\Models\UserNotificationSettings|null $settings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movie> $watchlist
 * @property-read int|null $watchlist_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User whereBiography($value)
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereProfileImage($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    public function friends(): HasMany
    {
        return $this->hasMany(Friendship::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(UserCollection::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Review::class);
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
