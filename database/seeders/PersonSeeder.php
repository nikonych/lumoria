<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\Country;
use App\Models\Department;
use App\Models\Language;
use App\Models\Person;
use App\Models\Photo;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = Language::all();
        $departments = Department::all();
        $countries = Country::all();

        // Create 200 people using the factory
        Person::factory(200)
            // For each person, also create 3 to 5 related photos
            ->has(Photo::factory()->count(rand(3, 5)))
            // For each person, also create 2 to 7 related roles in movies
            ->has(Role::factory()->count(rand(2, 7)))
            ->create()
            ->each(function (Person $person) use ($countries, $languages, $departments) {
                // Now, attach the many-to-many relationships for each created person

                // Attach a random number of languages (1 to 3)
                $person->languages()->attach(
                    $languages->random(rand(1, 3))->pluck('id')->toArray()
                );


                // Attach a random number of departments (1 or 2)
                $person->departments()->attach(
                    $departments->random(rand(1, 2))->pluck('id')->toArray()
                );

            });
    }
}
