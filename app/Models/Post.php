<?php

namespace App\Models;

use App\Models\Concerns\HasFeedItems;
use App\Models\Concerns\HasLocalScopes;
use App\Models\Concerns\HasMediaAttached;
use App\Models\Concerns\HasRelationships;
use App\Models\Concerns\LogsActivity;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\MediaLibrary\HasMedia;

class Post extends BaseModel implements Feedable, HasMedia
{
    use HasFeedItems;
    use HasLocalScopes;
    use HasMediaAttached;
    use HasRelationships;
    use LogsActivity;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
        'teaser',
        'published_at',
        'commercial',
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
        'published_at' => 'datetime',
        'commercial'   => 'boolean',
    ];



    public function scopeWithCategory($query, string $category): void
    {
        $query->whereHas('categories', function ($query) use ($category) {
            $query->where('slug', $category);
        });
    }


    public function getFormattedDate()
    {
        return $this->published_at->format('F jS Y');
    }

    public function getReadingTime(): float|int
    {
        $mins = round(str_word_count($this->body) / 250);

        if ($mins < 1) {
            return 1;
        }
        return $mins;
    }

    public function humanReadTime(): Attribute
    {
        return new Attribute(
            get: function () {
                $words   = Str::wordCount(strip_tags($this->body));
                $minutes = ceil($words / 200);

                return $minutes . ' ' . str('min')->plural($minutes) . ', '
                    . $words . ' ' . str('word')->plural($words);
            }
        );
    }

    public function getThumbnailUrl()
    {
        $isUrl = str_contains($this->image, 'http');

        if ($isUrl) {
            return $this->image;
        }

        return Storage::disk('public')->url($this->image);
    }

    public function getNextPost(): self|null
    {
        return $this->getPublishedPost('desc');
    }

    public function getPrevPost(): self|null
    {
        return $this->getPublishedPost('asc');
    }

    private function getPublishedPost(string $order): self|null
    {
        return self::query()
            ->published()
            ->orderBy('published_at', $order)
            ->limit(1)
            ->first();
    }
}
