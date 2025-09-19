@props(['movie', 'ratingPercentages'])

<div>
    <div class="flex space-x-5">
        <div class="flex flex-col items-center w-1/3 bg-bg-card p-5 rounded-sm">
            <div class="flex items-center gap-0.5">
                <x-base.stars :rating="$movie->rating" :movie_id="$movie->id"
                              spacing="space-x-1.5"/>
            </div>
            <span class="font-semibold text-2xl mt-5">
                                    {{ number_format($movie->rating, 1) }} von {{ 5 }}
                                </span>

            <span class="text-indigo-200 text-sm font-light">
                                    {{ number_format($movie->reviews_count) }} Bewertungen
                                </span>
            <div class="rating-histogram space-y-2 mt-5 w-full">
                @if($movie->hasReviews())
                    @for($rating = 5; $rating >= 1; $rating--)
                        @php
                            $percentage = $ratingPercentages[$rating] ?? 0;
                            $count = $movie->reviews()->where('rating', $rating)->count();
                        @endphp
                        <div class="flex items-center space-x-3">
                            <span class=" font-light">{{ $rating }}</span>
                            <div class="flex-1 bg-indigo-950 rounded-full h-3 relative">
                                <div
                                    class="bg-indigo-700 h-3 rounded-full transition-all duration-300"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-sm font-light min-w-[40px] text-right">{{ $percentage }}%</span>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
        @livewire('movies.create-review', ['movie' => $movie])
    </div>
    <div class="mt-5">
        <livewire:movies.movie-reviews :movie="$movie" />
    </div>
</div>
