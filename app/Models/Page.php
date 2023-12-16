<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Models\Concerns\HasLocalScopes;
use App\Models\Concerns\HasMediaAttached;
use App\Models\Concerns\HasRelationships;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends BaseModel implements HasMedia
{
    use HasFactory;
    use HasLocalScopes;
    use HasMediaAttached;
    use HasRelationships;
    use Sluggable;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'content',
        'description',
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
        'tags' => 'array',
    ];
}
