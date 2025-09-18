<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\PhotoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    /** @use HasFactory<PhotoFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


    protected $fillable = [
        'file_path'
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
