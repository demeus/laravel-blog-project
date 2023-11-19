<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'bg_color',
        'status',
    ];

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function posts() : BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
