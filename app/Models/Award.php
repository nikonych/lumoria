<?php

namespace App\Models;

use Database\Factories\AwardFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Award extends Model
{
    /** @use HasFactory<AwardFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category',
    ];


    public function winners(): HasMany
    {
        return $this->hasMany(AwardWinner::class);
    }

}
