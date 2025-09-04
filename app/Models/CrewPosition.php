<?php

namespace App\Models;

use Database\Factories\CrewPositionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrewPosition extends Model
{
    /** @use HasFactory<CrewPositionFactory> */
    use HasFactory;

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
