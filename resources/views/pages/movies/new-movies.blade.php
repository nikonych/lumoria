<x-layouts.app>
    <div class="mx-24 mt-12">
        <p class="text-indigo-400 text-sm"><a href="/movies" class="font-light cursor-pointer">Filme</a> / <a
                href="/movies/all" class="font-semibold cursor-pointer">Neuerscheinungen</a></p>
        <livewire:movies.all-movies title="Neuerscheinungen" sort-by="release_year_desc" />
    </div>

</x-layouts.app>
