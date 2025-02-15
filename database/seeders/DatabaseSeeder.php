<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Post;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminUser();
        $this->createCategories();
        $this->createSettings();
        $this->createPosts();
        $this->createPages();
    }

    private function createAdminUser(): void
    {
        User::factory()->create([
            'name'     => User::ROLE_ADMIN,
            'email'    => 'admin@admin.com',
            'password' => bcrypt('password'), // password
            'role'     => User::ROLE_ADMIN,
        ]);
    }

    private function createCategories(): void
    {
        $categories = [
            [
                'title' => 'Technology',
                'icon'  => 'technology',
            ],
            [
                'title' => 'Programming',
                'icon'  => 'programming',
            ],
            [
                'title' => 'Hardware',
                'icon'  => 'hardware',
            ],
            [
                'title' => 'Software',
                'icon'  => 'software',
            ],

            [
                'title' => 'Tutorials',
                'icon'  => 'tutorials',
            ],

        ];

        foreach ($categories as $category) {
            Category::query()->create($category);
        }
    }

    private function createSettings(): void
    {
        $settings = [
            'General'          => [
                'Site Name'                       => config("app.name"),
                'SEO Site Meta Title'             => 'My SEO Title',
                'Site Description'                => 'This is a description of the site.',
                'SEO Site Keywords'               => 'site, SEO, keywords',
                'Site Share Image'                => '/path/to/image.jpg',
                'Time Zone'                       => 'UTC',
                'Datetime Format'                 => 'Y-m-d H:i:s',
                'Display Cookie Notification Bar' => 'yes',
            ],
            'Code Integration' => [
                'Add code between head of the frontend' => '',
                'Add code before body of the frontend'  => '',
            ],

        ];

        foreach ($settings as $category => $keys) {
            foreach ($keys as $key => $value) {
                Settings::query()->create([
                    'category' => $category,
                    'key'      => $key,
                    'value'    => $value,
                    'type'     => 'text',
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

    private function createPages(): void
    {
        $pages = [
            'about-us' => [
                'title'       => 'About Us',
                'description' => 'About Us',
                'content'     => ''
            ],
        ];

        foreach ($pages as $slug => $page) {

            Page::query()->create([
                'title'       => $page['title'],
                'description' => $page['description'],
                'content'     => $page['content'],
                'user_id'     => User::find(1)->id,
            ]);
        }
    }
}
