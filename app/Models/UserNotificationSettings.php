<?php

namespace App\Models;

use Database\Factories\UserNotificationSettingsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotificationSettings extends Model
{
    /** @use HasFactory<UserNotificationSettingsFactory> */
    use HasFactory;

    protected $table = 'user_notification_settings';

    protected $fillable = [
        'email_new_movies',
        'email_new_recommendations',
        'email_friends_requests',
    ];

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
