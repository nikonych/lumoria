<?php

namespace App\Models;

use Database\Factories\CrewPositionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $position
 * @property int $person_id
 * @property int $movie_id
 * @property int $department_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\CrewPositionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrewPosition withoutTrashed()
 * @mixin \Eloquent
 */
class CrewPosition extends Model
{
    /** @use HasFactory<CrewPositionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'position',
    ];

    protected function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    protected function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    protected function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

}
