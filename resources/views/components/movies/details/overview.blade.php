@props(['movie'])
<div>
    <div class="flex justify-between mb-8">
        <p class="text-indigo-400 text-sm">
            <a href="/movies" class="font-light cursor-pointer">Filme</a> /
            <a href="/movies/all" class="font-light cursor-pointer">Alle anzeigen</a> /
            <a href="{{route('movies.details', $movie)}}"
               class="font-semibold cursor-pointer">{{$movie->title}}</a>
        </p>
        @auth
            @if(auth()->user()->id === $movie->created_by)
                <div class="flex space-x-2.5">
                    <x-base.button variant="secondary" icon="pen">
                        Bearbeiten
                    </x-base.button>
                    <x-base.button variant="danger" icon="trash">
                        Löschen
                    </x-base.button>
                </div>
            @endif
        @endauth

    </div>
    <div class="flex space-x-12">
        <!-- Movie poster and info here -->
        <div class="flex-shrink-0">
            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-xs rounded-xs">
        </div>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <h1 class="text-5xl font-bold">{{ $movie->title }}</h1>
                <button
                    class="group/btn rounded-full transition-all duration-300 text-gray-400 }}"
                    data-movie-id="{{ $movie->id }}"
                    disabled
                >
                    <svg class="w-12 h-12 text-gray-700"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </div>
            <div class="flex items-center space-x-2.5 mt-3.5">
                                <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                                    {{ $movie->release_year }}
                                </span>
                <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                                    {{ $movie->duration_minutes }} Min.
                                </span>
                <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                                    {{ $movie->age_rating }}
                                </span>
                @if($movie->genres->isNotEmpty())
                    <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                                        {{ $movie->genres->pluck('name')->implode(', ') }}
                                    </span>
                @endif
            </div>
            <div class="flex items-center gap-3 mt-3.5">
                <x-base.stars :rating="$movie->rating" :movie_id="$movie->id" spacing="space-x-1.5"
                              size="5"/>

                <span class="font-light text-sm">
                                    {{ number_format($movie->rating, 1) }} von {{ 5 }}
                                </span>

                <span class="text-slate-400 text-sm font-light">
                                    ({{ number_format($movie->reviews_count) }} Bewertungen)
                                </span>
            </div>
            <div class="mt-5">
                <dl class="grid grid-cols-2 max-w-2/3 font-light gap-y-1.5">
                    <dt class="">Originaltitel:</dt>
                    <dd class="text-slate-400">{{$movie->original_title}}</dd>
                    @if(!empty($movie->language))
                    <dt class="">Originalsprache:</dt>
                    <dd class="text-slate-400">{{$movie->language->name}}</dd>
                    @endif
                    @if(!empty($movie->country))
                    <dt class="">Produktionsland:</dt>
                    <dd class="text-slate-400">{{$movie->country->name}}</dd>
                    @endif
                </dl>
            </div>
            <div class="mt-5 font-light">
                <p>{{$movie->description}}</p>
            </div>
            @auth
            <div class="flex space-x-3.5 mt-5">
                <x-base.button icon="plus">Watchlist</x-base.button>
                <x-base.button icon="directory">Sammlung</x-base.button>
            </div>
            @endauth

        </div>
    </div>
</div>
