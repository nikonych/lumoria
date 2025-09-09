<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            'English',
            'German',
            'French',
            'Spanish',
            'Italian',
            'Russian',
            'Japanese',
            'Mandarin Chinese',
            'Korean',
            'Portuguese',
            'Hindi',
            'Arabic',
        ];

        // Loop through the array and create each language if it doesn't already exist.
        foreach ($languages as $languageName) {
            Language::firstOrCreate(['name' => $languageName]);
        }
    }
}
