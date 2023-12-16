<?php

namespace App\Enums;

use Illuminate\Support\Collection;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum VisibilityStatusEnum : string implements HasColor, HasLabel
{
    case ACTIVE = '1';
    case DISABLED = '0';

    public function getLabel() : string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::DISABLED => 'Disabled',

        };
    }

    public function getColor() : string|array|null
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::DISABLED => 'gray',
        };
    }

    public static function all() : Collection
    {
        return collect(self::cases());
    }
}
