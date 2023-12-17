<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class NavigationTopMenu extends Component
{
    public function render()
    {
        return view('livewire.navigation-top-menu');
    }

    #[Computed()]
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
