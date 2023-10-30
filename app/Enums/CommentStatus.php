<?php
namespace App\Enums;
use Illuminate\Support\Collection;

enum CommentStatus: int
{
    case Pending = 1;
    case Approved = 2;
    case Rejected = 3;



    public static function all(): Collection
    {
        return collect(self::cases());
    }
}
