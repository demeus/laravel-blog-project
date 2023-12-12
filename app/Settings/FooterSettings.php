<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FooterSettings extends Settings
{
    public string $copyright;

    public array $links;
    public bool $show_copyright;

    public static function group(): string
    {
        return 'footer';
    }
}
