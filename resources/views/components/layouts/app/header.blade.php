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

            <a href="/personen"
               class="{{ request()->is('personen*') ? 'text-indigo-400' : 'text-slate-50' }} transition-colors cursor-pointer duration-200 hover:text-indigo-400">
                Personen
            </a>
        </nav>
        <div class="flex space-x-6 items-center">
            @auth
                <button
                    class="bg-indigo-700 w-8 h-8 flex justify-center items-center rounded-md hover:bg-indigo-600 cursor-pointer">
                    <img src="{{ Vite::asset('resources/images/plus.svg') }}" alt="plus" class="w-3 h-3">
                </button>
            @endauth


            <livewire:base.input
                has-icon="true"
                class="w-3xs"/>

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
