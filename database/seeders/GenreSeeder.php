<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // A predefined list of common movie genres
        $genres = [
            'Action',
            'Adventure',
            'Animation',
            'Comedy',
            'Crime',
            'Documentary',
            'Drama',
            'Family',
            'Fantasy',
            'Horror',
            'Musical',
            'Mystery',
            'Romance',
            'Science Fiction',
            'Thriller',
            'Western',
        ];

        // Loop through the array and create each genre
        foreach ($genres as $genreName) {
            // Use firstOrCreate to avoid creating duplicates if the seeder is run again
            Genre::firstOrCreate(['name' => $genreName]);
        }
    }
}
