@props(['post'])

<div class="card bg-base-100 shadow-xl">
    <figure>
        <a wire:navigate href="{{ route('posts.show', $post->slug) }}">
            <img src="{{ $post->getThumbnailUrl() }}" alt="{{ $post->title }}"/>
        </a>
    </figure>
    <div class="card-body">
        <h2 class="card-title">
            <a wire:navigate href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
            <x-posts.category-badge :category="$post->category"/>
        </h2>
        <p>
            {{ $post->getExcerpt(15) }}
        </p>
        @if(is_countable($post->tags) && count($post->tags))
            <div class="card-actions justify-end">
                @foreach($post->tags as $tag)
                    <x-posts.tag-badge :tag="$tag->name"/>
                @endforeach
            </div>
        @endif

    </div>
</div>

{{--<div {{ $attributes }}>--}}
{{--    <a wire:navigate href="{{ route('posts.show', $post->slug) }}">--}}
{{--        <div>--}}
{{--            <img class="w-full rounded-xl" src="{{ $post->getThumbnailUrl() }}" alt="{{ $post->title }}">--}}
{{--        </div>--}}
{{--    </a>--}}
{{--    <div class="mt-3">--}}
{{--        <div class="flex items-center mb-2 gap-x-2">--}}

{{--                        @if ($category = $post->categories->first())--}}
{{--            <x-posts.category-badge :category="$post->category"/>--}}
{{--                        @endif--}}
{{--            <p class="text-sm text-gray-500">{{ $post->published_at }}</p>--}}
{{--        </div>--}}

{{--        <a wire:navigate href="{{ route('posts.show', $post->slug) }}"--}}
{{--           class="text-xl font-bold text-gray-900">{{ $post->title }}</a>--}}
{{--    </div>--}}
{{--</div>--}}
