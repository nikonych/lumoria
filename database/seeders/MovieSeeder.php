<?php

namespace Database\Seeders;

use App\Models\Department; // <-- 1. Import Department
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\Person;
use App\Models\Photo;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $allGenres = Genre::all();
        $allLanguages = Language::all();


        Movie::factory(50)
            ->has(Photo::factory()->count(rand(4, 8)))
            ->create()
            ->each(function (Movie $movie) use ($allGenres, $allLanguages) {
                $movie->genres()->attach($allGenres->random(rand(1, 3))->pluck('id')->toArray());

                if ($allLanguages->isNotEmpty()) {
                    $movie->language_id = $allLanguages->random()->id;
                    $movie->save(); // Save the updated movie with the language_id
                }
            });

    }
}
