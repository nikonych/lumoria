<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\AwardWinnerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $award_id
 * @property int|null $movie_id
 * @property int|null $person_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Award $award
 * @property-read \App\Models\Movie|null $movie
 * @property-read \App\Models\Person|null $person
 * @method static \Database\Factories\AwardWinnerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner whereAwardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AwardWinner withoutTrashed()
 * @mixin \Eloquent
 */
class AwardWinner extends Model
{
    /** @use HasFactory<AwardWinnerFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


    protected $fillable = [
        'award_id',
        'movie_id',
        'person_id',
    ];

    protected $table = 'award_winners';

    public function award(): BelongsTo
    {
        return $this->belongsTo(Award::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
