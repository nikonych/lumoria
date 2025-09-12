<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CrewPosition>
 */
class CrewPositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            'Regie',
            'Drehbuch',
            'Kamera',
            'Schnitt',
            'Musik',
            'Produzent',
            'Ton',
            'Szenenbild',
        ];

        return [
            'position' => $this->faker->randomElement($positions),

            'person_id' => Person::inRandomOrder()->first()->id ?? Person::factory(),
            'movie_id' => Movie::inRandomOrder()->first()->id ?? Movie::factory(),
        ];
    }
}
