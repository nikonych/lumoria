<?php

namespace Database\Seeders;

use App\Models\CrewPosition;
use App\Models\Department;
use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Seeder;

class CrewPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::all();
        $people = Person::pluck('id');

        if ($movies->isEmpty() || $people->isEmpty()) {
            return;
        }

        foreach ($movies as $movie) {
            $crewMembers = $people->random(min(8, $people->count()));

            foreach ($crewMembers as $personId) {
                CrewPosition::factory()->create([
                    'movie_id' => $movie->id,
                    'person_id' => $personId,
                    'department_id' => Department::inRandomOrder()->first()->id ?? Department::factory(),
                ]);
            }
        }
    }
}
