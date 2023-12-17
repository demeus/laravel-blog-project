@props(['category'])
@if($category)
    <x-badge wire:navigate href="{{ route('categories.show', $category) }}"
             :textColor="$category->text_color"
             :bgColor="$category->bg_color">
        {{ $category->title }}
    </x-badge>
@endif
