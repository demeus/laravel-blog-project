@props(['tag'])
@if($tag)
    <div class="badge badge-outline">#{{ $tag }}</div>
@endif
