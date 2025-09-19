<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\PhotoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    /** @use HasFactory<PhotoFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


    protected $fillable = [
        'file_path'
    ];

    public function getUrlAttribute(): ?string
    {
        if (!$this->file_path) {
            return null;
        }

        if (str_starts_with($this->file_path, 'http')) {
            return $this->file_path;
        }

        return Storage::url($this->file_path);
    }



    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
