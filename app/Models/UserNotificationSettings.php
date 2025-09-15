<?php

namespace App\Models;

use Database\Factories\UserNotificationSettingsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $email_new_movies
 * @property int $email_new_recommendations
 * @property int $email_friends_request
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserNotificationSettingsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings whereEmailFriendsRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings whereEmailNewMovies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings whereEmailNewRecommendations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSettings whereUserId($value)
 * @mixin \Eloquent
 */
class UserNotificationSettings extends Model
{
    /** @use HasFactory<UserNotificationSettingsFactory> */
    use HasFactory;

    protected $table = 'user_notification_settings';

    protected $fillable = [
        'email_new_movies',
        'email_new_recommendations',
        'email_friend_requests',
    ];

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
