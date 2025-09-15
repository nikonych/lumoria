<?php

namespace App\Models;

use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string|null $birth_date
 * @property string|null $death_date
 * @property string|null $birth_place
 * @property string|null $biography
 * @property string|null $nationality
 * @property string|null $profile_image
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AwardWinner> $awards
 * @property-read int|null $awards_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CrewPosition> $crewPositions
 * @property-read int|null $crew_positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Language> $languages
 * @property-read int|null $languages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Photo> $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\PersonFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereBiography($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereBirthPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereDeathDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person withoutTrashed()
 * @mixin \Eloquent
 */
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
