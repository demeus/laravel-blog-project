<footer class="bg-white">
    <div class="mx-auto max-w-7xl overflow-hidden px-6 py-20 sm:py-24 lg:px-8">
        <nav class="-mb-6 columns-2 sm:flex sm:justify-center sm:space-x-12" aria-label="Footer">
            <div class="pb-6">
                @foreach($links as $link)
                    <a class="text-sm leading-6 text-gray-600 hover:text-gray-900"
                       href="{{ $link['url'] }}">{{$link['label']}}</a>
                @endforeach
            </div>
        </nav>
        <div class="mt-10 flex justify-center space-x-10">
            @foreach($social_links as $social_link)
                <a href="{{ $social_link['url'] }}" target="_blank" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">{{ $social_link['name'] }}</span>
                    {{ svg($social_link['icon'], 'w-6 h-6') }}
                </a>
            @endforeach
        </div>
        @if($show_copyright)
            <p class="mt-10 text-center text-xs leading-5 text-gray-500">
                {{ $copyright }}
            </p>
        @endif
    </div>
</footer>


{{--<footer class="text-sm space-x-4 flex items-center border-t border-gray-100 flex-wrap justify-center py-4">--}}

{{--    <a class="text-gray-500 hover:text-yellow-500" href="">About Us</a>--}}
{{--    <a class="text-gray-500 hover:text-yellow-500" href="">Help</a>--}}
{{--    <a class="text-gray-500 hover:text-yellow-500" href="">Login</a>--}}
{{--    <a class="text-gray-500 hover:text-yellow-500" href="">Explore</a>--}}
{{--</footer>--}}

