<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Collection;

enum RoleEnum: string implements HasColor, HasLabel
{
    case ADMIN = 'ADMIN';
    case EDITOR = 'EDITOR';
    case USER = 'USER';


    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::EDITOR => 'Editor',
            self::USER => 'User',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ADMIN => 'danger',
            self::EDITOR => 'success',
            self::USER => 'gray',
        };
    }


    public static function all(): Collection
    {
        return collect(self::cases());
    }

}
