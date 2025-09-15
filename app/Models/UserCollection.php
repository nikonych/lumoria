<?php

namespace App\Models;

use Database\Factories\UserCollectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $is_public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserCollectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCollection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCollection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCollection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCollection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCollection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCollection whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCollection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCollection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCollection whereUserId($value)
 * @mixin \Eloquent
 */
class UserCollection extends Model
{
    /** @use HasFactory<UserCollectionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'is_public'
    ];

    protected function movies(): belongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }

    protected function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
