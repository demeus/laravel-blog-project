<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;


    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
        'published_at',
        'featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    /**
     * Get the author of the document.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Retrieve the categories associated with this model.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Retrieve the comments associated with this model.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the users who have liked this post.
     *
     * @return BelongsToMany
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }

    /**
     * Scope a query to only include published posts.
     *
     * @param Builder $query
     * @return void
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeWithCategory($query, string $category): void
    {
        $query->whereHas('categories', function ($query) use ($category) {
            $query->where('slug', $category);
        });
    }


    public function scopeFeatured($query): void
    {
        $query->where('featured', true);
    }

    public function scopePopular($query): void
    {
        $query->withCount('likes')
            ->orderBy("likes_count", 'desc');
    }

    public function scopeSearch($query, string $search = ''): void
    {
        $query->where('title', 'like', "%{$search}%");
    }

    public function getExcerpt($words = 30): string
    {
        return Str::words(strip_tags($this->body), $words);

        // return Str::limit(strip_tags($this->body), 150);
    }

    public function getFormattedDate()
    {
        return $this->published_at->format('F jS Y');
    }

     public function getReadingTime()
     {
         $mins = round(str_word_count($this->body) / 250);

         return ($mins < 1) ? 1 : $mins;
     }

    public function humanReadTime(): Attribute
    {
        return new Attribute(
            get: function () {
                $words = Str::wordCount(strip_tags($this->body));
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
