<?php

namespace App\Models;

use App\Models\Concerns\HasLocalScopes;
use App\Models\Concerns\HasMediaAttached;
use App\Models\Concerns\HasRelationships;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Feed\Feedable;
use Spatie\MediaLibrary\HasMedia;

class Page extends BaseModel implements HasMedia
{
    use HasFactory;
    use Sluggable;
    use HasMediaAttached;
    use HasLocalScopes;
    use HasMediaAttached;
    use HasRelationships;


    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
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
        'tags' => 'array',
    ];


}
