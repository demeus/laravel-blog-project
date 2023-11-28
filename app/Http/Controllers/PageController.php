<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show(Page $page): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('page', compact('page'));
    }
}
