<?php

namespace App\Http\Controllers;

use App\Facades\Posts;
use App\Models\Post;
use App\Service\PostViewService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('posts.index');
    }

    /**
     * Show the post.
     *
     * @param  Post  $post  The post to be shown.
     * @param  Request  $request  The current request.
     * @return Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|Application The view for displaying the post.
     */
    public function show(Post $post, Request $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $this->postViewService->handleView($request, $post);
        $recommendations = Posts::recommendations($post);
        return view('posts.show', compact('post', 'recommendations'));
    }
}
