<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = Review::factory(500)->create();

        $movieIdsToUpdate = $reviews->pluck('movie_id')->unique();

        foreach ($movieIdsToUpdate as $movieId) {
            $movie = Movie::find($movieId);

            if ($movie) {
                $newAverageRating = $movie->reviews()->avg('rating');

                $movie->update(['rating' => $newAverageRating]);
            }
        }
    }
}
