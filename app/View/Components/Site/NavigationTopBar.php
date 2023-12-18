<?php

namespace App\View\Components\Site;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class NavigationTopBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = $this->categories();
        return view('components.site.navigation-top-bar', compact('categories'));
    }


    public function categories()
    {
        return Cache::remember('categories', now()->addDays(3), function () {
            return Category::query()
                ->active()
                ->where('show_in_navigation', true)
                ->whereHas('posts', function ($query) {
                    $query->published();
                })->take(10)->get();
        });
    }
}
