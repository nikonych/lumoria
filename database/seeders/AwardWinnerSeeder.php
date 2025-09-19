<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\AwardWinner;
use App\Models\Category;
use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Seeder;

class AwardWinnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $awards = Award::all();
        $categories = Category::all();
        $movies = Movie::all();
        $people = Person::all();

        if ($awards->isEmpty() || $movies->isEmpty() || $people->isEmpty() || $categories->isEmpty()) {
            return;
        }

        foreach ($people as $person) {
            $random = rand(0, 6);
            $awardsToWin = $awards->random($random);
            $categoriesToWin = $categories->random($random);

            foreach ($awardsToWin as $index => $award) {
                $category = $categoriesToWin[$index] ?? null;

                if ($category) {
                    AwardWinner::create([
                        'award_id' => $award->id,
                        'category_id' => $category->id,
                        'movie_id' => $movies->random()->id,
                        'person_id' => $person->id,
                    ]);
                }
            }
        }
    }
}
