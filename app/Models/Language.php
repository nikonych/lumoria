<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\LanguageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    /** @use HasFactory<LanguageFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


    protected $fillable = [
        'name'
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }
}
