{{-- resources/views/components/card-list.blade.php --}}
@props([
    'movie' => null,
    'rank' => null,
    ]
)

<div class="flex bg-bg-card rounded-lg p-4 group pr-6">
    {{-- Rank --}}
    @if($rank)
        <div class="w-8">
            <span class="text-2xl font-semibold text-indigo-500">{{ $rank }}</span>
        </div>
    @endif

    {{-- Poster --}}
    <div @class([
                'flex-shrink-0',
                'content-center',
                'ml-4' => $rank,
                'ml-2' => !$rank,
        ])>
        <a class="cursor-pointer" href="{{route('movies.details', $movie)}}">
            <img src="{{ $movie->poster_image }}"
                 alt="{{ $movie->title }}"
                 class="w-16 h-24 object-cover rounded-xs">
        </a>
    </div>

    {{-- MovieSeeder Info --}}
    <div class="flex-1 ml-6 content-around">
        <a class="cursor-pointer" href="{{route('movies.details', $movie)}}">
            <h3 class="text-2xl font-semibold mb-3">
                {{ $movie->title }}
            </h3>
        </a>


        {{-- Year and Genres --}}
        <div class="flex items-center mb-3 space-x-2.5">
            <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                {{ $movie->release_year }}
            </span>

            @if($movie->genres->isNotEmpty())
                <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                    {{ $movie->genres->pluck('name')->implode(', ') }}
                </span>
            @endif
        </div>

    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col items-end justify-center gap-3 ml-6">
        @auth
            <div class="flex items-center gap-5">
                <button
                    class="group/btn rounded-full cursor-pointer transition-all duration-300 {{ $movie->is_favorite ? 'text-pink-400' : 'text-gray-400 hover:text-pink-400' }}"
                    data-movie-id="{{ $movie->id }}"
                    data-favorite="{{ $movie->is_favorite ? 'true' : 'false' }}"
                >
                    <svg class="w-8 h-8 text-indigo-700 hover:text-indigo-600"
                         fill="{{ $movie->is_favorite ? 'currentColor' : 'none' }}"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
                <x-base.button class="group/btn p-1.5" icon="plus"/>
            </div>
        @endauth
        @guest
            <div class="flex items-center gap-5">
                <button
                    class="group/btn rounded-full transition-all duration-300 text-gray-400 }}"
                    data-movie-id="{{ $movie->id }}"
                    disabled
                >
                    <svg class="w-8 h-8 text-gray-700"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>

                <button
                    disabled
                    class="group/btn p-1.5 rounded-md bg-gray-700 text-gray-400"
                >
                    <svg class="w-5 h-5"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </button>
            </div>
        @endguest

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-0.5">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($movie->rating))
                        <svg class="w-6 h-6 text-indigo-600 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @elseif($i == ceil($movie->rating) && $movie->rating - floor($movie->rating) >= 0.5)
                        <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 20 20">
                            <defs>
                                <linearGradient id="half-{{ $movie->id }}-{{ $i }}">
                                    <stop offset="50%" stop-color="currentColor"/>
                                    <stop offset="50%" stop-color="transparent"/>
                                </linearGradient>
                            </defs>
                            <path fill="url(#half-{{ $movie->id }}-{{ $i }})"
                                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            <path stroke="currentColor" stroke-width="1" fill="none"
                                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endif
                @endfor
            </div>

            <span class="font-light text-sm">
                {{ number_format($movie->rating, 1) }} von {{ 5 }}
            </span>

            <span class="text-slate-400 text-sm font-light">
                ({{ number_format($movie->reviews_count) }} Bewertungen)
            </span>
        </div>
    </div>
</div>

