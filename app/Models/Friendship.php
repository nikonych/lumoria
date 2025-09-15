<?php

namespace App\Models;

use Database\Factories\FriendshipFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\FriendshipFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereUserId($value)
 * @mixin \Eloquent
 */
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
