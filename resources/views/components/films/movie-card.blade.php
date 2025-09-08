{{-- resources/views/components/movie-card.blade.php --}}
@props([
    'rank' => 1,
    'title' => 'Die Verurteilten',
    'year' => '2023',
    'genres' => ['Drama', 'Thriller', 'Krimi'],
    'rating' => 4.6,
    'maxRating' => 5,
    'reviewsCount' => 216,
    'poster' => Vite::asset("resources/images/films/shawshank.png"),
    'movieId' => null,
    'isFavorite' => false
])

<div class="flex bg-bg-card rounded-lg p-4 group pr-6">
    {{-- Rank --}}
    <div class="w-8">
        <span class="text-2xl font-semibold text-indigo-500">{{ $rank }}</span>
    </div>

    {{-- Poster --}}
    <div class="flex-shrink-0 ml-4 content-center">
        <img src="{{ $poster }}"
             alt="{{ $title }}"
             class="w-16 h-24 object-cover rounded-md">
    </div>

    {{-- Movie Info --}}
    <div class="flex-1 ml-6 content-around">
        <h3 class="text-2xl font-semibold mb-3">
            {{ $title }}
        </h3>

        {{-- Year and Genres --}}
        <div class="flex items-center mb-3 space-x-2.5">
            <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                {{ $year }}
            </span>

            @if(count($genres) > 0)
                <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                    {{ implode(', ', $genres) }}
                </span>
            @endif
        </div>

    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col items-end justify-center gap-3 ml-6">
        {{-- Favorite Button --}}
        <div class="flex items-center gap-5">
            <button
                onclick="toggleFavorite({{ $movieId }})"
                class="group/btn rounded-full transition-all duration-300 hover:bg-white/10 {{ $isFavorite ? 'text-pink-400' : 'text-gray-400 hover:text-pink-400' }}"
                data-movie-id="{{ $movieId }}"
                data-favorite="{{ $isFavorite ? 'true' : 'false' }}"
            >
                <svg class="w-8 h-8 text-indigo-700"
                     fill="{{ $isFavorite ? 'currentColor' : 'none' }}"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>

            {{-- Add to List Button --}}
            <button
                onclick="addToList({{ $movieId }})"
                class="group/btn p-1.5 rounded-md bg-indigo-700 hover:text-indigo-400 hover:bg-white/10 transition-all duration-300"
            >
                <svg class="w-5 h-5 transition-transform duration-300 group-hover/btn:scale-110"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </button>
        </div>
        <div class="flex items-center gap-3">
            {{-- Stars --}}
            <div class="flex items-center gap-0.5">
                @for($i = 1; $i <= $maxRating; $i++)
                    @if($i <= floor($rating))
                        <svg class="w-6 h-6 text-indigo-600 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @elseif($i == ceil($rating) && $rating - floor($rating) >= 0.5)
                        <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 20 20">
                            <defs>
                                <linearGradient id="half-{{ $movieId }}-{{ $i }}">
                                    <stop offset="50%" stop-color="currentColor"/>
                                    <stop offset="50%" stop-color="transparent"/>
                                </linearGradient>
                            </defs>
                            <path fill="url(#half-{{ $movieId }}-{{ $i }})"
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

            {{-- Rating Text --}}
            <span class="font-light text-sm">
                {{ number_format($rating, 1) }} von {{ $maxRating }}
            </span>

            {{-- Reviews Count --}}
            <span class="text-slate-400 text-sm font-light">
                ({{ number_format($reviewsCount) }} Bewertungen)
            </span>
        </div>
    </div>
</div>

{{-- JavaScript for interactivity --}}
@push('scripts')
    <script>
        function toggleFavorite(movieId) {
            const button = document.querySelector(`[data-movie-id="${movieId}"]`);
            const isFavorite = button.dataset.favorite === 'true';

            // Toggle visual state immediately
            const svg = button.querySelector('svg');
            if (isFavorite) {
                button.classList.remove('text-pink-400');
                button.classList.add('text-gray-400', 'hover:text-pink-400');
                svg.setAttribute('fill', 'none');
                button.dataset.favorite = 'false';
            } else {
                button.classList.remove('text-gray-400', 'hover:text-pink-400');
                button.classList.add('text-pink-400');
                svg.setAttribute('fill', 'currentColor');
                button.dataset.favorite = 'true';
            }

            // Send AJAX request
            fetch(`/movies/${movieId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({favorite: !isFavorite})
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        // Revert on error
                        toggleFavorite(movieId);
                    }
                })
                .catch(() => {
                    // Revert on error
                    toggleFavorite(movieId);
                });
        }

        function addToList(movieId) {
            // Implement add to list functionality
            console.log('Add to list:', movieId);
        }
    </script>
@endpush
