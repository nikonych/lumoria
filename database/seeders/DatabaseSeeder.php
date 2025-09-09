<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

            MovieSeeder::class,
            PersonSeeder::class,

            AwardSeeder::class,
        ]);
    }
}
