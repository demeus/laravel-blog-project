<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostRepository implements PostRepositoryContract
{
    public function get(string $slug): Post|null
    {
        return Post::query()->where('slug', $slug)
            ->with('categories', 'media')
            ->published(1 === auth()->id())
            ->first();
    }

    public function latest(int $page = null): LengthAwarePaginator|Collection
    {
        /** @var LengthAwarePaginator|Collection */
        return Post::query()->with('categories', 'media')
            ->published()
            ->orderByDesc('published_at')
            ->when(
                $page,
                fn($query) => $query->paginate(21),
                fn($query) => $query->limit(9)->get(),
            );
    }

    public function popular(): Collection
    {
        /** @var LengthAwarePaginator|Collection */
        return Post::query()->with('categories', 'media')
            ->published()
            ->orderBy('sessions_last_7_days', 'desc')
            ->limit(9)
            ->get();
    }

    public function recommendations(Post $post): Collection
    {
        return Post::query()->with('category', 'media')
            ->withAnyTags($post->tags)
            ->published()
            ->whereNotIn('id', [$post->id])
            ->when(
                fn($query) => $query->inRandomOrder()->limit(9)
            )
            ->get();
    }

}
