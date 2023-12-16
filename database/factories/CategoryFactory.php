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
    public function definition() : array
    {
        return [
            'title' => $this->faker->title(),
            'text_color' => $this->faker->colorName(),
            'bg_color' => $this->faker->colorName(),
            'status' => $this->faker->boolean(),
            'icon' => null,
        ];
    }
}
