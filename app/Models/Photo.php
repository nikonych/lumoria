<?php

namespace App\Models;

use Database\Factories\PhotoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    /** @use HasFactory<PhotoFactory> */
    use HasFactory;

    protected $fillable = [
        'file_path'
    ];

    protected function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    protected function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
