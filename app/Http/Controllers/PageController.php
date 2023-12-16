<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show(Page $page) : View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('page', compact('page'));
    }
}
