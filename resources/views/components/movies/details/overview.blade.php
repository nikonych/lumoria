@props(['movie'])
<div>
    <div class="flex justify-between mb-8">
        <p class="text-indigo-400 text-sm">
            <a href="/movies" class="font-light cursor-pointer">Filme</a> /
            <a href="/movies/all" class="font-light cursor-pointer">Alle anzeigen</a> /
            <a href="{{route('movies.details', $movie)}}"
               class="font-semibold cursor-pointer">{{$movie->title}}</a>
        </p>
        <div class="flex space-x-2.5">
            <button class="bg-bg-secondary text-white px-4 py-1.5 rounded-sm">
                <div class="flex items-center space-x-2.5 text-sm">
                    <p>Bearbeiten</p>
                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2.35938 8.09375L9.48438 0.96875C10.0703 0.382812 11.0312 0.382812 11.6172 0.96875L12.5312 1.88281C12.6016 1.95312 12.6719 2.04688 12.7188 2.11719C13.1172 2.70312 13.0469 3.5 12.5312 4.01562L5.40625 11.1406C5.38281 11.1641 5.33594 11.1875 5.3125 11.2344C5.07812 11.4219 4.82031 11.5625 4.53906 11.6562L1.70312 12.4766C1.51562 12.5469 1.30469 12.5 1.16406 12.3359C1 12.1953 0.953125 11.9844 1 11.7969L1.84375 8.96094C1.9375 8.63281 2.125 8.32812 2.35938 8.09375ZM2.92188 9.28906L2.38281 11.1172L4.21094 10.5781C4.35156 10.5312 4.49219 10.4609 4.60938 10.3438L9.97656 4.97656L8.5 3.52344L3.15625 8.89062C3.13281 8.89062 3.13281 8.91406 3.10938 8.9375C3.01562 9.03125 2.96875 9.14844 2.92188 9.28906Z"
                            fill="#F8FAFC"/>
                    </svg>
                </div>

            </button>
            <button class="bg-rot text-white px-4 py-1.5 rounded-sm">

                <div class="flex items-center space-x-2.5 text-sm">
                    <p>Löschen</p>
                    <svg width="11" height="13" viewBox="0 0 11 13" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.4375 2.375C10.7422 2.375 11 2.63281 11 2.9375C11 3.26562 10.7422 3.5 10.4375 3.5H10.1562L9.59375 11.1172C9.52344 11.9141 8.89062 12.5 8.09375 12.5H3.38281C2.58594 12.5 1.95312 11.9141 1.88281 11.1172L1.32031 3.5H1.0625C0.734375 3.5 0.5 3.26562 0.5 2.9375C0.5 2.63281 0.734375 2.375 1.0625 2.375H2.67969L3.54688 1.08594C3.78125 0.734375 4.20312 0.5 4.64844 0.5H6.82812C7.27344 0.5 7.69531 0.734375 7.92969 1.08594L8.79688 2.375H10.4375ZM4.64844 1.625C4.57812 1.625 4.50781 1.67188 4.48438 1.71875L4.03906 2.375H7.4375L6.99219 1.71875C6.96875 1.67188 6.89844 1.625 6.82812 1.625H4.64844ZM9.03125 3.5H2.44531L3.00781 11.0469C3.03125 11.2344 3.19531 11.375 3.38281 11.375H8.09375C8.28125 11.375 8.44531 11.2344 8.46875 11.0469L9.03125 3.5Z"
                            fill="white"/>
                    </svg>
                </div>
            </button>
        </div>
    </div>
    <div class="flex space-x-12">
        <!-- Movie poster and info here -->
        <div class="flex-shrink-0">
            <img src="{{ $movie->poster_image }}" alt="{{ $movie->title }}" class="w-xs rounded-xs">
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
                                    FSK {{ $movie->age_rating }}
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

                    <dt class="">Originalsprache:</dt>
                    <dd class="text-slate-400">{{$movie->language->name}}</dd>

                    <dt class="">Produktionsland:</dt>
                    <dd class="text-slate-400">{{$movie->country->name}}</dd>
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
