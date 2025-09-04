<?php

namespace App\Models;

use Database\Factories\UserCollectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserCollection extends Model
{
    /** @use HasFactory<UserCollectionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'is_public'
    ];

    protected function movies(): belongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }

    protected function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
