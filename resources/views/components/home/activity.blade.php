<div>
    <p class="text-2xl">Aktivität deiner Freunde</p>

    <div class="mt-9 space-y-5 text-lg">
        <div class="space-y-1 bg-bg-card p-6 rounded-md">
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

                <x-base.stars rating="4" size="4" spacing="space-x-2"/>
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
        <div class="space-y-1 bg-bg-card p-6 rounded-md">
            <p><span class="cursor-pointer text-indigo-200">AndreTpx</span> hat <span
                    class="cursor-pointer text-indigo-200">Crazy Chicks</span> zu Favoriten hinzugefügt</p>
            <p class="text-sm font-light">vor 4h</p>
        </div>
        <div class="space-y-1 bg-bg-card p-6 rounded-md">
            <p><span class="cursor-pointer text-indigo-200">AndreTpx</span> hat <span
                    class="cursor-pointer text-indigo-200">Crazy Chicks</span> zu Favoriten hinzugefügt</p>
            <p class="text-sm font-light">vor 4h</p>
        </div>
        <div class="space-y-1 bg-bg-card p-6 rounded-md">
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

</div>
