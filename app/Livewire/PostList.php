<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    #[Url()]
    public string $sort = 'desc';

    #[Url()]
    public string $search = '';

    #[Url()]
    public string $category = '';

    #[Url()]
    public bool $popular = false;

    public function setSort($sort): void
    {
        $this->sort = ('desc' === $sort) ? 'desc' : 'asc';
    }

    #[On('search')]
    public function updateSearch($search): void
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search   = '';
        $this->category = '';
        $this->resetPage();
    }

    #[Computed()]
    public function posts()
    {
        return Post::query()
            ->published()
            ->with('author', 'category', 'tags')
            ->when($this->activeCategory, function ($query) {
                $query->withCategory($this->category);
            })
            ->when($this->popular, function ($query) {
                $query->popular();
            })
            ->search($this->search)
            ->orderBy('published_at', $this->sort)
            ->paginate(3);
    }

    #[Computed()]
    public function activeCategory()
    {
        if (null === $this->category || '' === $this->category) {
            return null;
        }

        return Category::where('slug', $this->category)->first();
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
