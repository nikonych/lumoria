<?php

namespace App\Models;

use Database\Factories\ReviewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /** @use HasFactory<ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'rating',
    ];

    protected function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
