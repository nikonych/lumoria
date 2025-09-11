<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Award>
 */
class AwardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $awardNames = ['Oscar', 'Golden Globe', 'Palme d\'Or', 'Goldener Bär', 'BAFTA'];
        $categories = [
            'Bester Film', 'Beste Regie', 'Bester Hauptdarsteller',
            'Beste Hauptdarstellerin', 'Bestes Drehbuch', 'Beste Kamera'
        ];

        return [
            'name' => $this->faker->randomElement($awardNames),
            'category' => $this->faker->randomElement($categories),
        ];
    }
}
