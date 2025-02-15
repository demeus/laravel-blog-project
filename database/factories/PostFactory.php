<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ensure that categories exist
        if (Category::count() === 0) {
            $this->command->info('No categories found. Seeding them...');
            $this->call(CategorySeeder::class);
        }

        return [
            'user_id'      => User::factory(),
            'category_id'  => Category::all()->random()->id, // Assign a random existing category
            'title'        => $this->faker->sentence(),
            'image'        => $this->faker->imageUrl(),
            'body'         => $this->faker->paragraph(10),
            'published_at' => $this->faker->dateTimeBetween('-10 month', '+1 month'),
            'commercial'   => $this->faker->boolean(10),
        ];
    }
}
