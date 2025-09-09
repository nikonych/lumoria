<div>
    <p class="text-2xl">Aktivität deiner Freunde</p>

    <div class="mt-9 space-y-5">
        <div class="space-y-1 bg-bg-card p-6 rounded-md text-lg">
            <p><span class="cursor-pointer text-indigo-200">AndreTpx</span> hat den Film <span
                    class="cursor-pointer text-indigo-200">Crazy Chicks</span> erstellt.</p>
            <p class="text-sm font-light">vor 4h</p>
        </div>

        <div class="bg-bg-card p-6 rounded-md">
            <div class="flex justify-between items-center">

                <div class="flex items-center gap-4">
                    <img src="{{ Vite::asset('resources/images/movies/alles.png') }}"
                         alt="Imitation Game Poster"
                         class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="text-lg text-indigo-200">Imitation Game</p>
                        <p class="text-sm font-light">von <span
                                class="cursor-pointer font-medium">AndreTpx</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-0.5">
                    {{-- Filled Star SVG --}}
                    @for ($i = 0; $i < 4; $i++)
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor

                    {{-- Empty Star SVG --}}
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
            </div>

            <div class="border-b border-y-indigo-950 mt-3.5"></div>

            <div class="mt-2.5">
                <h3 class="text-lg text-indigo-200">I Really Love This Movie!</h3>
                <p class="text-sm font-light line-clamp-2 mt-2.5">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ac risus a
                    risus elementum vehicula. (...)
                </p>
            </div>
        </div>
        <div class="space-y-1 bg-bg-card p-6 rounded-md text-lg">
            <p><span class="cursor-pointer text-indigo-200">AndreTpx</span> hat <span
                    class="cursor-pointer text-indigo-200">Crazy Chicks</span> zu Favoriten hinzugefügt</p>
            <p class="text-sm font-light">vor 4h</p>
        </div>
        <div class="space-y-1 bg-bg-card p-6 rounded-md text-lg">
            <p><span class="cursor-pointer text-indigo-200">AndreTpx</span> hat <span
                    class="cursor-pointer text-indigo-200">Crazy Chicks</span> zu Favoriten hinzugefügt</p>
            <p class="text-sm font-light">vor 4h</p>
        </div>
        <div class="space-y-1 bg-bg-card p-6 rounded-md text-lg">
            <p><span class="cursor-pointer text-indigo-200">AndreTpx</span> hat dir eine Freundschaftsanfrage gesendet</p>
            <p class="text-sm font-light">vor 4h</p>
            <div class="flex w-full justify-between gap-4">
                <button class="w-1/2 bg-bg-secondary hover:bg-gray-600 text-xs py-3 rounded-md">
                    Ablehnen
                </button>
                <button class="w-1/2 bg-indigo-700 hover:bg-indigo-600 text-xs py-3 rounded-md">
                    Akzeptieren
                </button>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 w-full h-16 bg-gradient-to-t from-black via-black/60 to-transparent pointer-events-none z-10"></div>
</div>
