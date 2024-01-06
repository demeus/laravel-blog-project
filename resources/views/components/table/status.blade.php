@props(['row'])

@php
    $statusList = [
        'active' => ['icon' => 'check-square', 'color' => 'green-600'],
        'archived' => ['icon' => 'archive', 'color' => 'gray-600'],
        'deleted' => ['icon' => 'trash-2', 'color' => 'gray-400']
    ];

    $status = $statusList[$row->status] ?? null;
@endphp

@if($status)
    <span class="flex items-center  text-{{ $status['color'] }}">
            @svg("{$status['icon']}", 'w-4 h-4 mr-1')
            {{ str($row->status)->title() }}
        </span>

@endif