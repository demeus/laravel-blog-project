<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $categoryNames = ['Technology', 'Programming', 'Hardware', 'Software', 'Reviews', 'Tutorials'];

        $textColors = ['text-red-500', 'text-blue-500', 'text-green-500', 'text-yellow-500', 'text-indigo-500'];
        $bgColors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-indigo-500'];

        $name = $this->faker->unique()->randomElement($categoryNames);

        return [
            'title' => $name,
            'slug' => Str::slug($name),
            'text_color' => $this->faker->randomElement($textColors),
            'bg_color' => $this->faker->randomElement($bgColors),
        ];
    }
}
