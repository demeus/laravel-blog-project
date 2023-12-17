<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostCacheRepository implements PostRepositoryContract
{
    public function __construct(
        public PostRepository $repository
    ) {
    }

    public function get(string $slug): Post|null
    {
        return cache()->rememberForever(
            "post_$slug",
            fn() => $this->repository->get($slug)
        );
    }

    public function latest(int $page = null): LengthAwarePaginator|Collection
    {
        $key = 'posts_latest';

        if ($page) {
            $key .= "_page_$page";
        }

        return cache()->tags(['posts'])->rememberForever(
            $key,
            fn() => $this->repository->latest($page)
        );
    }

    public function popular(): Collection
    {
        return cache()->tags(['posts'])->rememberForever(
            'posts_popular',
            fn() => $this->repository->popular()
        );
    }

    public function recommendations(Post $post): Collection
    {
        return cache()->tags(['posts'])->rememberForever(
            "post_{$post->id}_recommendations",
            fn() => $this->repository->recommendations($post)
        );
    }
}
