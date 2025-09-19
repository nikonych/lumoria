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

        return [
            'name' => $this->faker->randomElement($awardNames),
        ];
    }
}
