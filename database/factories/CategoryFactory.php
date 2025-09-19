<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Beste Regie',
                'Bester Hauptdarsteller',
                'Beste Hauptdarstellerin',
                'Bester Nebendarsteller',
                'Beste Nebendarstellerin',
                'Bester Film',
                'Beste Kamera',
                'Bester Ton',
                'Beste Filmmusik',
                'Bestes Drehbuch',
                'Beste Ausstattung',
                'Beste Kostüme',
                'Beste Maske',
                'Beste Montage',
                'Beste Spezialeffekte',
            ]),
        ];
    }
}
