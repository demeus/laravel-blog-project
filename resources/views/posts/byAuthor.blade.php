<x-app-layout :title="$user->name">
    <div class="grid w-full grid-cols-4 gap-10">
        <div class="col-span-4 md:col-span-3">
            <livewire:post.show-by-author :user="$user"/>
        </div>
        <div id="side-bar"
             class="sticky top-0 h-screen col-span-4 px-3 py-6 pt-10 space-y-10 border-t border-gray-100 border-t-gray-100 md:border-t-none md:col-span-1 md:px-6 md:border-l">
            @include('posts.partials.search-box')
            <div>
                <h3 class="mb-3 text-lg font-semibold text-gray-900">Recommended Topics</h3>
                <div class="flex flex-wrap justify-start gap-2 topics">
                    @foreach ($categories as $category)
                        <x-button wire:click="$dispatch('setCategory', {{ $category->slug }})">
                            {{ $category->title }}
                        </x-button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
