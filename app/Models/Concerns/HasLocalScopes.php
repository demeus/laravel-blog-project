<?php

namespace App\Models\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasLocalScopes
{
    /**
     * Get a sequence of posts using their IDs in the exact order provided.
     */
    public function scopeAsSequence(Builder $query, Collection|array $sequence) : void
    {
        $sequence = collect($sequence);

        $query
            ->whereIn('id', $sequence)
            ->orderByRaw('FIELD(id, ' . $sequence->join(',') . ')');
    }

    public function scopePublished(Builder $query, bool $condition = false) : void
    {
        if (! $condition) {
            $query->where('published_at', '<=', now());
        }
    }

    public function scopeUnpublished(Builder $query) : void
    {
        $query->whereNull('published_at')->orWhere('published_at', '>', now());
    }


    public function scopeFeatured($query): void
    {
        $query->where('featured', true);
    }

    public function scopePopular($query): void
    {
        $query->withCount('likes')
            ->orderBy('likes_count', 'desc');
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
}
