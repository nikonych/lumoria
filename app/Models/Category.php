<?php
// app/Models/Category.php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;

    protected $fillable = [
        'name',
    ];

    public function awardWinners(): HasMany
    {
        return $this->hasMany(AwardWinner::class);
    }
}
