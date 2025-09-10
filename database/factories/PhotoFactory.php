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
        $width = 1280;
        $height = 720;

        return [
            'file_path' => "https://picsum.photos/{$width}/{$height}",
        ];
    }
}
