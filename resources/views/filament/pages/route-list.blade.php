<x-filament-panels::page>
    <div class="fi-ta-content divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10">

        <x-table>
            <x-slot name="thead">
                <x-table.th>Method</x-table.th>
                <x-table.th>Route</x-table.th>
                <x-table.th>Name</x-table.th>
                <x-table.th>Corresponding Action</x-table.th>
            </x-slot>
            @foreach ($records as $value)
                <x-table.tr>
                    <x-table.td>
                        {{ implode(", ", $value['methods']) }}
                    </x-table.td>
                    <x-table.td>{{$value['uri'] }}</x-table.td>
                    <x-table.td>{{$value['name'] }}</x-table.td>
                    <x-table.td>{{$value['action_name'] }}</x-table.td>
                </x-table.tr>
            @endforeach
        </x-table>

    </div>

</x-filament-panels::page>
