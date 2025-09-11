<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    public function definition(): array
    {

        return [
            'file_path' => 'https://picsum.photos/seed/' . fake()->word() . '1280/720',
        ];
    }
}
