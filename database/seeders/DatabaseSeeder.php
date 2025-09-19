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
            CountrySeeder::class,
            GenreSeeder::class,
            LanguageSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,

            MovieSeeder::class,
            PersonSeeder::class,

            AwardSeeder::class,
            CategorySeeder::class,
            AwardWinnerSeeder::class,
            ReviewSeeder::class,
            CrewPositionsSeeder::class,
            WatchlistSeeder::class,
        ]);
    }
}
