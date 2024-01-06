<?php

namespace App\Models;

use App\Enums\VisibilityStatusEnum;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'text_color',
        'icon',
        'status',
        'show_in_navigation',
        'sort_order',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected $casts = [
        'show_in_navigation' => 'boolean',
        'status'             => VisibilityStatusEnum::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            $category->sort_order = self::max('sort_order') + 1;
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', VisibilityStatusEnum::ACTIVE);
    }
}
