<div>
    @if($showBanner && !Session::get('cookie_consent'))
        <div x-data="{ open: false }" x-init="() => setTimeout(() => open = true, 500)"
             class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">

            <div x-show="open"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter="transition duration-200 transform ease"
                 x-transition:leave="transition duration-200 transform ease"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="max-w-screen-lg mx-auto fixed bg-white inset-x-5 p-5 bottom-10 rounded-lg drop-shadow-2xl flex gap-4 flex-wrap md:flex-nowrap text-center md:text-left items-center justify-center md:justify-between">
                <div class="w-full">This website uses cookies to ensure you get the best experience on our website.
                    <a href="#" class="text-indigo-600 whitespace-nowrap  hover:underline">Learn more</a></div>
                <div class="flex gap-4 items-center flex-shrink-0">
                    <!-- setTimeout is for demo purposes only. Remove it & add to cookies
                         so that the popup won't appear next time they load. -->
                    <button @click="open = false, setTimeout(() => open = true, 1500)"
                            class="text-indigo-600 focus:outline-none hover:underline">Decline
                    </button>
                    <button wire:click="closeBanner"
                            class="btn btn-accent">
                        Allow Coockies
                    </button>
                </div>
            </div>

        </div>
        {{--    <div class="fixed bottom-0 left-0 w-full bg-slate-200 p-5 rounded-xl">--}}
        {{--        <div--}}
        {{--            class="items-center max-w-3xl flex flex-col md:flex-row items-start md:items-center justify-between gap-8 "--}}
        {{--        >--}}
        {{--            <svg--}}
        {{--                class="w-12 h-12 md:w-10 md:h-10"--}}
        {{--                viewBox="0 0 24 24"--}}
        {{--                fill="none"--}}
        {{--                xmlns="http://www.w3.org/2000/svg"--}}
        {{--            >--}}
        {{--                <g id="Environment / Cookie">--}}
        {{--                    <g id="Vector">--}}
        {{--                        <path--}}
        {{--                            d="M12.1521 4.08723C12.1513 3.71959 12.1001 3.3538 12 3C16.9683 3.00545 20.9944 7.03979 21 12C21.0161 16.9625 16.9705 20.9835 12 20.9997C7.02946 21.0158 3.01615 16.963 3 12.0005C4.11168 12.2363 5.27038 11.9981 6.1499 11.2795C7.0562 10.5452 7.5789 9.43935 7.5702 8.27407C7.56959 8.01195 7.5461 7.75072 7.5 7.49268C8.51784 7.89624 9.67043 7.76409 10.5708 7.14162C11.5696 6.44537 12.161 5.3034 12.1521 4.08723Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M3.00195 7.002V7H3V7.00195L3.00195 7.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M8.00195 3.002V3H8V3.00195L8.00195 3.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M4.00195 3.002V3H4V3.00195L4.00195 3.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M10.002 17.002V17H10V17.002L10.002 17.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M15.002 15.002V15H15V15.002L15.002 15.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M11.002 12.002V12H11V12.002L11.002 12.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M16.002 10.002V10H16V10.002L16.002 10.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M3.00195 7.002V7H3V7.00195L3.00195 7.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M8.00195 3.002V3H8V3.00195L8.00195 3.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                        <path--}}
        {{--                            d="M4.00195 3.002V3H4V3.00195L4.00195 3.002Z"--}}
        {{--                            class="stroke-slate-600"--}}
        {{--                            stroke-width="2"--}}
        {{--                            stroke-linecap="round"--}}
        {{--                            stroke-linejoin="round"--}}
        {{--                        />--}}
        {{--                    </g>--}}
        {{--                </g>--}}
        {{--            </svg>--}}
        {{--            <div>--}}
        {{--                <h4 class="text-slate-600 font-bold text-base">We use cookies</h4>--}}
        {{--                <p class="text-slate-600 text-xs mt-2 md:mt-1">--}}
        {{--                    Cookies help us deliver the best experience on our website. By using--}}
        {{--                    our website, you agree to the use of cookies. Find out how we use--}}
        {{--                    cookies.--}}
        {{--                </p>--}}
        {{--            </div>--}}
        {{--            <div class="flex">--}}
        {{--                <button--}}
        {{--                    class="text-xs text-slate-600 border-[1px] py-2 px-5 rounded-tl-2xl rounded-bl-2xl bg-white hover:bg-slate-600 hover:text-white"--}}
        {{--                >--}}
        {{--                    Accept--}}
        {{--                </button>--}}
        {{--                <button--}}
        {{--                    class="text-xs text-slate-600 border-[1px] py-2 px-5 rounded-tr-2xl rounded-br-2xl bg-white hover:bg-slate-600 hover:text-white"--}}
        {{--                >--}}
        {{--                    Reject--}}
        {{--                </button>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--    </div>--}}
    @endif
</div>


