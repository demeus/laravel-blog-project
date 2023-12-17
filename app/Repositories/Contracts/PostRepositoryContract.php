<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PostRepositoryContract
{
    public function get(string $slug): ?Post;

    public function latest(int $page = null): LengthAwarePaginator|Collection;

    public function popular(): Collection;

    public function recommendations(Post $post): Collection;
}
