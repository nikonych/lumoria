<header>
    <div class="flex justify-between items-center my-3.5 mx-24">
        <a href="/">
            <img src="{{ Vite::asset('resources/images/logo_dunkel.svg') }}" alt="logo" class="pb-1.5 cursor-pointer">
        </a>
        <nav class="space-x-24 text-lg">
            <a href="/"
               class="{{ request()->is('/') ? 'text-indigo-400' : 'text-slate-50' }} transition-colors cursor-pointer duration-200 hover:text-indigo-400">
                Home
            </a>
            <a href="/movies"
               class="{{ request()->is('movies*') ? 'text-indigo-400' : 'text-slate-50' }} transition-colors cursor-pointer duration-200 hover:text-indigo-400">
                Filme
            </a>

            <a href="/people"
               class="{{ request()->is('people*') ? 'text-indigo-400' : 'text-slate-50' }} transition-colors cursor-pointer duration-200 hover:text-indigo-400">
                Personen
            </a>
        </nav>
        <div class="flex space-x-6 items-center">
            @auth
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <x-base.button icon="plus" @click="open = !open" />

                    <div
                        x-show="open"
                        x-transition
                        @click="open = false"
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-indigo-950 ring-1 ring-white/10 shadow-lg"
                        style="display: none;"
                    >
                        <div class="py-1">
                            <a href="{{route('movies.create')}}"
                            class="block px-4 py-2 text-sm text-slate-200 hover:bg-indigo-600 hover:text-white">
                                Film hinzufügen
                            </a>
                            <a href="{{route('people.create')}}"
                            class="block px-4 py-2 text-sm text-slate-200 hover:bg-indigo-600 hover:text-white">
                                Person hinzufügen
                            </a>
                        </div>
                    </div>
                </div>
            @endauth


            <x-base.input
                wire:model.live="searchQuery"
                :has-icon="true"
                class="w-3xs"
                placeholder="Suche..."
            />

            @auth
                <div>
                    <a href="/profile">
                        @if (auth()->user()->profile_image)
                            <img src="{{ auth()->user()->profile_image }}" alt="avatar"
                                 class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-indigo-900 flex items-center justify-center">
                            <span class="text-indigo-200 text-lg">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </span>
                            </div>
                        @endif
                    </a>
                </div>
            @endauth
            @guest
                <a href="{{ route('login') }}"
                   class="bg-indigo-700 h-8 px-4 flex text-xs justify-center items-center rounded-sm font-light hover:bg-indigo-600">
                    Login
                </a>
            @endguest
        </div>
    </div>
    <div class="w-full border-b border-indigo-950"></div>
</header>
