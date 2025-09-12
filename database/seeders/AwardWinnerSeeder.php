<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\AwardWinner;
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
        $movies = Movie::all();
        $people = Person::all();

        if ($awards->isEmpty() || $movies->isEmpty() || $people->isEmpty()) {
            return;
        }

        foreach ($people as $person) {
            $awardsToWin = $awards->random(rand(0, 3));
            foreach ($awardsToWin as $award) {
                AwardWinner::create([
                    'award_id' => $award->id,
                    'movie_id' => $movies->random()->id,
                    'person_id' => $person->id,
                ]);
            }
        }
    }
}
