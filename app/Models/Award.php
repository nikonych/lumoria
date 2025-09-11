<?php

namespace App\Models;

use Database\Factories\AwardFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Award extends Model
{
    /** @use HasFactory<AwardFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
    ];


    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'award_person')
            ->withPivot('movie_id');
    }

    public function movie(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'award_movie');
    }

}
