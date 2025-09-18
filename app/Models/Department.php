<?php

namespace App\Models;

use App\Models\Traits\Userstamps;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    /** @use HasFactory<DepartmentFactory> */
    use HasFactory, SoftDeletes;
    use Userstamps;


    protected $fillable = [
        'name',
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }
}
