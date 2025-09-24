<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    protected $fillable = [
        'user_id',
        'activity_type',
        'activity_data',
    ];

    protected $casts = [
        'activity_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Получение активностей друзей
    public static function getFriendsActivities($userId, $limit = 20)
    {
        $friendIds = Friendship::where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                ->orWhere('friend_id', $userId);
        })
            ->where('status', 'accepted')
            ->get()
            ->map(function($friendship) use ($userId) {
                return $friendship->user_id === $userId
                    ? $friendship->friend_id
                    : $friendship->user_id;
            });

        return self::where(function($query) use ($friendIds, $userId) {
            // Активности друзей (НО НЕ заявки на дружбу)
            $query->where(function($subQuery) use ($friendIds) {
                $subQuery->whereIn('user_id', $friendIds)
                    ->where('activity_type', '!=', 'friend_request_sent');
            })
                // ИЛИ заявки на дружбу, адресованные конкретно вам
                ->orWhere(function($subQuery) use ($userId) {
                    $subQuery->where('activity_type', 'friend_request_sent')
                        ->whereRaw("JSON_EXTRACT(activity_data, '$.target_user_id') = ?", [$userId])
                        ->whereExists(function($existsQuery) use ($userId) {
                            $existsQuery->select(\DB::raw(1))
                                ->from('friendships')
                                ->whereRaw('friendships.id = CAST(JSON_EXTRACT(user_activities.activity_data, "$.friendship_id") AS INTEGER)')
                                ->where('friend_id', $userId)
                                ->where('status', 'pending');
                        });
                });
        })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    public function getDisplayData()
    {
        $data = $this->activity_data;

        return match($this->activity_type) {
            'movie_created' => [
                'message' => '{user} hat den Film {movie} erstellt.',
                'movie_title' => $data['movie_title'] ?? null,
                'movie_id' => $data['movie_id'] ?? null,
            ],
            'person_created' => [
                'message' => '{user} hat die Person {person} erstellt.',
                'person_name' => $data['person_name'] ?? null,
                'person_id' => $data['person_id'] ?? null,
            ],
            'movie_rated' => [
                'message' => '{user} hat {movie} bewertet.',
                'movie_title' => $data['movie_title'] ?? null,
                'movie_id' => $data['movie_id'] ?? null,
                'rating' => $data['rating'] ?? null,
                'review_title' => $data['review_title'] ?? null,
                'review_content' => $data['review_content'] ?? null,
                'movie_poster' => $data['movie_poster'] ?? null,
            ],
            'movie_favorited' => [
                'message' => '{user} hat {movie} zu Favoriten hinzugefügt.',
                'movie_title' => $data['movie_title'] ?? null,
                'movie_id' => $data['movie_id'] ?? null,
            ],
            'friend_request_sent' => [
                'message' => '{user} hat dir eine Freundschaftsanfrage gesendet.',
                'target_user_id' => $data['target_user_id'] ?? null,
                'friendship_id' => $data['friendship_id'] ?? null,
            ],
            default => [
                'message' => 'Unbekannte Aktivität',
            ],
        };
    }
}
