<?php

namespace App\Models;

use Database\Factories\GenreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    /** @use HasFactory<GenreFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
}
