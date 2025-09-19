<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\AwardWinnerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwardWinner extends Model
{
    /** @use HasFactory<AwardWinnerFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


    protected $fillable = [
        'award_id',
        'movie_id',
        'person_id',
        'category_id',
    ];

    protected $table = 'award_winners';

    public function award(): BelongsTo
    {
        return $this->belongsTo(Award::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
