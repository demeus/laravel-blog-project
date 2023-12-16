<?php

namespace App\Service;

use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;

class PostViewService
{
    public function handleView(Request $request, Post $post) : void
    {
        PostView::query()
            ->create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'post_id' => $post->id,
                'user_id' => $request->user()?->id,
            ]);
    }
}
