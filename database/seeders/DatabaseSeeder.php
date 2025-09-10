<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            GenreSeeder::class,
            LanguageSeeder::class,
            DepartmentSeeder::class,

            MovieSeeder::class,
            PersonSeeder::class,

            AwardSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
