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
        $awardNames = ['Academy Award', 'Golden Globe', 'BAFTA Award', 'Screen Actors Guild Award'];
        $awardCategories = ['Best Actor', 'Best Actress', 'Best Director', 'Best Picture', 'Best Screenplay', 'Best Cinematography'];

        return [
            'name' => $this->faker->randomElement($awardNames),
            'category' => $this->faker->randomElement($awardCategories),
        ];
    }
}
