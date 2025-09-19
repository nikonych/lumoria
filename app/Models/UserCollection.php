<?php

namespace App\Models;

use Database\Factories\UserCollectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected $casts = [
        'is_public' => 'boolean'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'movie_user_collection');
    }

}
