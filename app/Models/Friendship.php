<?php

namespace App\Models;

use Database\Factories\FriendshipFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friendship extends Model
{
    /** @use HasFactory<FriendshipFactory> */
    use HasFactory;

    protected $fillable = [
        'status'
    ];


    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function friend(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
