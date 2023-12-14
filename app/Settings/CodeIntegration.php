<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CodeIntegration extends Settings
{

    public static function group(): string
    {
        return 'code';
    }
}