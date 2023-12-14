<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FooterSettings extends Settings
{

    public array $links;

    public array $social_links;

    public bool $show_copyright;

    public string $copyright;

    public static function group(): string
    {
        return 'footer';
    }
}
