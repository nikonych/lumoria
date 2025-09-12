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
    }
}
