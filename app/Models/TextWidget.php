<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TextWidget extends Model
{
    use HasFactory;

     protected $fillable = [
        'key',
        'image',
        'title',
        'content',
        'active'
    ];


    public static function getWidget(string $key)
    {
        return Cache::get('text-widget-' . $key, function () use ($key) {
            return self::query()->where('key', $key)->first();
        });
    }

    public static function getTitle(string $key): string
    {
        $widget = self::getWidget($key);

        if ($widget) {
            return $widget->title;
        }
        return '';
    }

    public static function getContent(string $key): string
    {
        $widget = self::getWidget($key);

        if ($widget) {
            return $widget->content;
        }
        return '';
    }
}
