<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

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
            'title' => fake()->word(),
            'category_id' => fake()->numberBetween(1, 5),
            'synopsis' => fake()->text(100),
            'duration' => '2:34',
            'trailer_link' => 'https://youtu.be/',
            'poster' => UploadedFile::fake()->image('poster.png'),
        ];
    }
}
