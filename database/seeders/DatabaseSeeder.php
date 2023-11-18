<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createAdminUser();
        $this->createCategories();
        $this->createSettings();
        $this->createPosts();
    }

    private function createAdminUser(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'), // password
            'role' => User::ROLE_ADMIN,
        ]);
    }

    private function createCategories(): void
    {
        $categoryNames = ['Technology', 'Programming', 'Hardware', 'Software', 'Reviews', 'Tutorials'];
        $textColors = ['text-red-500', 'text-blue-500', 'text-green-500', 'text-yellow-500', 'text-indigo-500'];
        $bgColors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-indigo-500'];

        foreach ($categoryNames as $index => $categoryName) {
            Category::query()->create([
                'title' => $categoryName,
                'text_color' => $textColors[$index % count($textColors)],
                'bg_color' => $bgColors[$index % count($bgColors)],
            ]);
        }
    }

    private function createSettings(): void
    {
        $settings = [
            'General' => [
                'Site Name' => 'My Site',
                'SEO Site Meta Title' => 'My SEO Title',
                'Site Description' => 'This is a description of the site.',
                'SEO Site Keywords' => 'site, SEO, keywords',
                'Site Share Image' => '/path/to/image.jpg',
                'Time Zone' => 'UTC',
                'Datetime Format' => 'Y-m-d H:i:s',
                'Display Cookie Notification Bar' => 'yes'
            ],
            'Code Integration' => [
                'Add code between <head> & </head> of the frontend' => '',
                'Add code before </body> of the frontend' => '',
            ],

        ];

        foreach ($settings as $category => $keys) {
            foreach($keys as $key => $value) {
                Setting::query()->create([
                    'category' => $category,
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }
    }

    private function createPosts(): void
    {
        Post::factory(100)
            ->has(Comment::factory(random_int(1, 3)))
            ->create();
    }

}

