<table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
    @isset($thead)
        <thead>
        {{ $thead }}
        </thead>
    @endisset
    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
    {{ $slot }}
    </tbody>
</table>
