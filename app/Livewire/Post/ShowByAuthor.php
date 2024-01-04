<?php

namespace App\Livewire\Post;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ShowByAuthor extends Component
{
    public User $user;

    use WithPagination;

    #[Url()]
    public string $search = '';

    #[Url()]
    public string $sort = 'desc';

    #[Url()]
    public string $category = '';


    #[On('search')]
    public function updateSearch($search): void
    {
        $this->search = $search;
        $this->resetPage();
    }


    #[Computed()]
    public function posts()
    {
        return $this->user->posts()
            ->published()
            ->with('category', 'tags')
            ->when($this->category, function ($query) {
                $query->whereHas('category', function ($query) {
                    $query->where('slug', $this->category);
                });
            })
            ->search($this->search)
            ->orderBy('published_at', $this->sort)
            ->paginate(10);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.post.show-by-author');
    }
//
//    #[Computed()]
//    public function activeCategory()
//    {
//        if (null === $this->category || '' === $this->category) {
//            return null;
//        }
//
//        return Category::where('slug', $this->category)->first();
//    }

    public function setSort($sort): void
    {
        $this->sort = ('desc' === $sort) ? 'desc' : 'asc';
    }


    public function clearFilters(): void
    {
        $this->search   = '';
        $this->category = '';
        $this->resetPage();
    }


}
