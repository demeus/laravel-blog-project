@props(['post'])

<div class="card bg-base-100 shadow-xl image-full">
    <figure>
        <img src="{{ $post->getThumbnailUrl() }}" alt="{{ $post->title }}"/>
    </figure>
    <div class="card-body">
        <a wire:navigate href="{{ route('posts.show', $post->slug) }}">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p>{{ $post->getExcerpt(15) }}</p>
        </a>
    </div>
</div>
