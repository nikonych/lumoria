<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Seeder;

class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Award::factory(50)->create();

        $awards = Award::all();
        $movies = Movie::all();
        $people = Person::all();

        if ($awards->isEmpty() || $movies->isEmpty() || $people->isEmpty()) {
            return;
        }

        foreach ($movies as $movie) {
            $movie->awards()->attach(
                $awards->random(rand(0, 3))->pluck('id')->toArray()
            );
        }

        foreach ($people as $person) {
            $personAwards = $awards->random(rand(0, 2));

            foreach ($personAwards as $award) {
                $person->awards()->attach($award->id, [
                    'movie_id' => $movies->random()->id
                ]);
            }
        }
    }
}
