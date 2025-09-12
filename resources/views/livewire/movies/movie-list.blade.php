<div class="mt-8">
    @if ($title)
        <p class="text-2xl">{{ $title }}</p>
    @endif
    <div class="relative group mt-5">
        <div id="film-carousel"
             class="w-full flex flex-nowrap overflow-x-auto snap-x snap-mandatory scroll-smooth scrollbar-hide gap-5">
            @foreach($movies as $movie)
                <div class="snap-start flex-shrink-0">
                    <x-movies.card :movie="$movie"/>
                </div>
            @endforeach
        </div>

        <x-pagination :paginator="$movies" />

    </div>
</div>
