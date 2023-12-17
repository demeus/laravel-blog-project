<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;

class ShowCategoryController extends Controller
{
    public function __invoke(Category $category) : View
    {
        return view('categories.show', compact('category'));
    }
}
