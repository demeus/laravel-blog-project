<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class PostCategoryList extends Component
{
    use WithPagination;

    public Category $category;

    #[Url()]
    public string $sort = 'desc';

    #[Url()]
    public string $search = '';

    #[Url()]
    public bool $popular = false;


    public function setSort($sort) : void
    {
        $this->sort = ('desc' === $sort) ? 'desc' : 'asc';
    }

    #[On('search')]
    public function updateSearch($search) : void
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function clearFilters() : void
    {
        $this->search = '';
        $this->resetPage();
    }

    #[Computed()]
    public function posts()
    {
        return Post::query()
            ->published()
            ->with('author', 'category')
            ->withCategory($this->category->slug)
            ->when($this->popular, function ($query) {
                $query->popular();
            })
            ->search($this->search)
            ->orderBy('published_at', $this->sort)
            ->paginate(3);
    }


    public function render()
    {
        return view('livewire.post-category-list');
    }
}
