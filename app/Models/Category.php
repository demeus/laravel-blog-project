<?php

namespace App\Models;

use App\Enums\VisibilityStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

    public function sluggable() : array
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

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function scopeActive(Builder $query) : void
    {
        $query->where('status', VisibilityStatusEnum::ACTIVE);
    }
}
