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
            'age_rating' => $this->faker->randomElement([0, 6, 12, 16, 18]),
            'description' => $this->faker->paragraph(4),
            'trailer_url' => 'https://www.youtube.com/watch?v=wqAp4h7cjoM',
            'poster_image' =>'https://picsum.photos/seed/' . fake()->word() . '/400/600',
            'country_id' => Country::inRandomOrder()->first()->id ?? null, // Assign a random existing country
        ];
    }
}
