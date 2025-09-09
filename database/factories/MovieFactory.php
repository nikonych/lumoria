<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'original_title' => $this->faker->words(4, true),
            'release_year' => $this->faker->year(),
            'duration_minutes' => $this->faker->numberBetween(90, 180),
            'age_rating' => $this->faker->randomElement(['G', 'PG', 'PG-13', 'R']),
            'description' => $this->faker->paragraph(4),
            'trailer_url' => 'https://youtube.com/watch?v=dQw4w9WgXcQ',
            'poster_image' => $this->faker->imageUrl(400, 600, 'movies'),
            'country_id' => Country::inRandomOrder()->first()->id ?? null, // Assign a random existing country
        ];
    }
}
