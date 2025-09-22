<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $birthDate = $this->faker->dateTimeBetween('-80 years', '-20 years');

        return [
            'name' => $this->faker->name(),
            'birth_date' => $birthDate,
            'death_date' => $this->faker->optional(0.2)->dateTimeBetween($birthDate, 'now'),
            'birth_place' => $this->faker->city() . ', ' . $this->faker->country(),
            'biography' => $this->faker->paragraph(30),
            'description' => $this->faker->paragraph(12),
            'profile_image' => 'https://picsum.photos/seed/' . fake()->word() . '/400/600',
            'nationality_id' => Country::inRandomOrder()->first()?->id,
        ];
    }
}
