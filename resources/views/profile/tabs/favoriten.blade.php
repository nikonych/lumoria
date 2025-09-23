<div class="flex flex-col space-y-12">
    <div class="">
        <div class="mb-5 flex space-x-2.5 items-center">
            <p class="text-3xl">Filme</p>
            <span class="bg-indigo-200 text-indigo-700 px-3.5 py-1.5 rounded-full text-xs">
                        {{ auth()->user()->favoriteMovies()->count() }}
                    </span>
        </div>
        <x-carousel-pagination :items="auth()->user()->favoriteMovies" :per-page="8">
            <div x-ref="container"
                 class="flex scrollbar-hide overflow-x-auto scroll-smooth snap-x snap-mandatory">
                @foreach(auth()->user()->favoriteMovies as $movie)
                    <div class="flex-shrink-0 w-1/2 sm:w-1/4 md:w-1/3 lg:w-1/7">
                        <x-movies.card-mini :movie="$movie"/>
                    </div>
                @endforeach
            </div>
        </x-carousel-pagination>
    </div>
    <div class="">
        <div class="mb-5 flex space-x-2.5 items-center">
            <p class="text-3xl">Personen</p>
            <span class="bg-indigo-200 text-indigo-700 px-3.5 py-1.5 rounded-full text-xs">
                        {{ auth()->user()->favoritePeople()->count() }}
                    </span>
        </div>
        <x-carousel-pagination :items="auth()->user()->favoritePeople" :per-page="5">
            <div x-ref="container"
                 class="flex scrollbar-hide overflow-x-auto scroll-smooth snap-x snap-mandatory space-x-5">
                @foreach(auth()->user()->favoritePeople as $person)
                    <div class="flex-shrink-0 w-full sm:w-1/3 lg:w-1/8">
                        <x-movies.person-card :person="$person"/>
                    </div>
                @endforeach
            </div>
        </x-carousel-pagination>
    </div>
</div>
