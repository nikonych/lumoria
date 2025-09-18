<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\CrewPositionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class CrewPosition extends Model
{
    /** @use HasFactory<CrewPositionFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


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
