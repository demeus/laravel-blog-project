<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Service\PostViewService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class PostController extends Controller
{
    private PostViewService $postViewService;

    public function __construct(PostViewService $postViewService)
    {
        $this->postViewService = $postViewService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|Application The view for displaying the list of categories.
     */
    public function index() : View|\Illuminate\Foundation\Application|Factory|Application
    {
        $categories = Cache::remember('categories', now()->addDays(3), function () {
            return Category::query()->whereHas('posts', function ($query) {
                $query->published();
            })->take(10)->get();
        });

        return view('posts.index', compact('categories'));
    }

    /**
     * Show the post.
     *
     * @param  Post  $post    The post to be shown.
     * @param  Request  $request The current request.
     * @return Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|Application The view for displaying the post.
     */
    public function show(Post $post, Request $request) : Factory|\Illuminate\Foundation\Application|View|Application
    {
        $this->postViewService->handleView($request, $post);

        return view('posts.show', compact('post'));
    }
}
