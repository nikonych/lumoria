<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\GenreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    /** @use HasFactory<GenreFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


    protected $fillable = [
        'name',
    ];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
