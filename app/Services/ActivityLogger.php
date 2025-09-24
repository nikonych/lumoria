<?php

namespace App\Services;

use App\Models\UserActivity;
use App\Models\User;
use App\Models\Movie;
use App\Models\Person;
use App\Models\Review;
use App\Models\Friendship;

class ActivityLogger
{
    public static function logMovieCreated(User $user, Movie $movie): void
    {
        UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => 'movie_created',
            'activity_data' => [
                'movie_id' => $movie->id,
                'movie_title' => $movie->title,
            ],
        ]);
    }

    public static function logPersonCreated(User $user, Person $person): void
    {
        UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => 'person_created',
            'activity_data' => [
                'person_id' => $person->id,
                'person_name' => $person->name,
            ],
        ]);
    }

    public static function logMovieRated(User $user, Review $review): void
    {
        UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => 'movie_rated',
            'activity_data' => [
                'movie_id' => $review->movie->id,
                'movie_title' => $review->movie->title,
                'movie_poster' => $review->movie->poster_url,
                'rating' => $review->rating,
                'review_title' => $review->title,
                'review_content' => $review->description,
            ],
        ]);
    }

    public static function logMovieFavorited(User $user, Movie $movie): void
    {
        UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => 'movie_favorited',
            'activity_data' => [
                'movie_id' => $movie->id,
                'movie_title' => $movie->title,
            ],
        ]);
    }

    public static function logFriendRequestSent(User $sender, User $receiver, Friendship $friendship): void
    {
        UserActivity::create([
            'user_id' => $sender->id,
            'activity_type' => 'friend_request_sent',
            'activity_data' => [
                'target_user_id' => $receiver->id,
                'friendship_id' => $friendship->id,
            ],
        ]);
    }
}
