<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public string $site_description;

    public array $site_keywords;

    public string $time_zone;

    public string $datetime_format;

    public bool $display_cookie_notification_bar;

    public bool $site_active;



    #[\Override]
    public static function group(): string
    {
        return 'general';
    }


//    public static function casts(): array
//    {
//        return [
//            'site_keywords' => 'array',
//        ];
//    }


}
