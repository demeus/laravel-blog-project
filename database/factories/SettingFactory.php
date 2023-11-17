<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition()
    {
        return [
            'key' => $this->faker->unique()->word,
            'value' => $this->faker->word,
            'category' => $this->faker->randomElement([
                'General', 'Language', 'Earnings', 'Protection',
                'Users', 'Captcha', 'Code Integration', 'Social Media Links',
                'Email', 'Social Login', 'AdLinkFly', 'Cron']),
        ];
    }
}
