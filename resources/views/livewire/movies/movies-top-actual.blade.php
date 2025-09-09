<div>
    <div class="mx-24 mt-12">
        <p class="text-indigo-400 text-sm"><a href="/movies" class="font-light cursor-pointer">Filme</a> / <a
                href="/movies/top-actual" class="font-semibold cursor-pointer">Top - aktuell</a></p>

        <div class="flex justify-between items-end">
            <h2 class="text-5xl mt-8">Top - aktuell</h2>
            <div class="flex gap-1.5 items-center">
                <p class="">Sortieren nach</p>

                <livewire:base-selection
                    wire:model.live="sortBy"
                    :options="$sortOptions"
                    :select-first="true"
                />
            </div>
        </div>

        <div class="mt-10">
            <div class="space-y-2.5">
                {{-- REPLACED @for with a real @foreach loop --}}
                @foreach($movies as $movie)
                    <x-movies.movie-card-list :movie="$movie" /> {{-- Pass the whole film object --}}
                @endforeach
            </div>

            {{-- ADDED Laravel's pagination links --}}
            <div class="mt-8">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</div>
