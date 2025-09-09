<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            'USA',
            'United Kingdom',
            'Germany',
            'France',
            'Canada',
            'Australia',
            'Japan',
            'South Korea',
            'India',
            'Spain',
            'Italy',
            'China',
            'Russia',
            'Brazil',
            'Mexico',
        ];

        // Loop through the array and create each country if it doesn't already exist.
        foreach ($countries as $countryName) {
            Country::firstOrCreate(['name' => $countryName]);
        }
    }
}
