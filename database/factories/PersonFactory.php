<?php

namespace Database\Factories;

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
            'nationality' => $this->faker->country(),
            'description' => $this->faker->paragraph(12),
            'profile_image' => 'https://picsum.photos/seed/' . fake()->word() . '/400/600',
        ];
    }
}
