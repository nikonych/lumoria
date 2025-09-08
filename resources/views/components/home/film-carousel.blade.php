@props([
    'title',
    'films' => [],
])

<div class="mt-8">
    <p class="text-2xl">{{ $title }}</p>
    <div class="relative group mt-5">
        <div id="film-carousel"
             class="w-full flex flex-nowrap overflow-x-auto snap-x snap-mandatory scroll-smooth scrollbar-hide gap-5">
            @for ($i = 0; $i < 8; $i++)
                <div class="snap-start flex-shrink-0 w-48">
                    <x-film-card
                        title="Die Entdeckung der Unendlichkeit"
                        imageUrl="{{ Vite::asset('resources/images/films/theory.png') }}"
                        :genres="['Drama', 'Biografie']"
                    />
                </div>
                <div class="snap-start flex-shrink-0 w-48">
                    <x-film-card
                        title="Die Entdeckung"
                        imageUrl="{{ Vite::asset('resources/images/films/theory.png') }}"
                        :genres="['Drama', 'Biografie']"
                    />
                </div>
            @endfor
                <div class="absolute top-0 right-0 w-16 h-full bg-gradient-to-l from-black/60 via-black/30 to-transparent pointer-events-none z-10"></div>
        </div>

        <div id="carousel-pagination" class="flex justify-center items-center gap-2 mt-4">
            {{--                                ##TODO Paginierung--}}
        </div>

    </div>
</div>
