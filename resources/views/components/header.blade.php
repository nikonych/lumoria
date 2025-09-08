<header>
    <div class="flex justify-between items-center my-3.5 mx-24">
        <img src="{{ Vite::asset('resources/images/logo_dunkel.svg') }}" alt="logo" class="pb-1.5 cursor-pointer">
        <nav class="space-x-24 text-lg">
            <a href="/"
               class="{{ request()->is('/') ? 'text-indigo-400' : 'text-slate-50' }} transition-colors cursor-pointer duration-200 hover:text-indigo-400">
                Home
            </a>
            <a href="/films"
               class="{{ request()->is('films*') ? 'text-indigo-400' : 'text-slate-50' }} transition-colors cursor-pointer duration-200 hover:text-indigo-400">
                Filme
            </a>

            <a href="/personen"
               class="{{ request()->is('personen*') ? 'text-indigo-400' : 'text-slate-50' }} transition-colors cursor-pointer duration-200 hover:text-indigo-400">
                Personen
            </a>
        </nav>
        <div class="flex space-x-6 items-center">
            @auth
                <button class="bg-indigo-700 w-8 h-8 flex justify-center items-center rounded-md hover:bg-indigo-600 cursor-pointer">
                    <img src="{{ Vite::asset('resources/images/plus.svg') }}" alt="plus" class="w-3 h-3">
                </button>
            @endauth

            <div class="relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.8125 11.5391C12.0469 11.7734 12.0469 12.125 11.8125 12.3359C11.7188 12.4531 11.5781 12.5 11.4375 12.5C11.2734 12.5 11.1328 12.4531 11.0156 12.3359L7.875 9.19531C7.03125 9.875 5.97656 10.25 4.85156 10.25C2.17969 10.25 0 8.07031 0 5.375C0 2.70312 2.15625 0.5 4.85156 0.5C7.52344 0.5 9.72656 2.70312 9.72656 5.375C9.72656 6.52344 9.35156 7.57812 8.67188 8.39844L11.8125 11.5391ZM1.125 5.375C1.125 7.46094 2.78906 9.125 4.875 9.125C6.9375 9.125 8.625 7.46094 8.625 5.375C8.625 3.3125 6.9375 1.625 4.875 1.625C2.78906 1.625 1.125 3.3125 1.125 5.375Z"
                            class="fill-slate-50 group-focus-within:fill-indigo-400"/>
                        />

                    </svg>

                </div>
                <input type="text" id="search" wire:model="search"
                       class="pl-7 focus:outline-none placeholder:text-slate-50 font-light text-xs bg-input-dark/85 focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500 w-3xs p-2.5"
                       placeholder="Suche..."/>
            </div>
            @auth
                <div>
                    <a href="/profile">
                    @if (auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="avatar"
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
