<x-layouts.app>
    <div class="mx-24 mt-12">
        <p class="text-indigo-400 text-sm"><a href="/movies" class="font-light cursor-pointer">Filme</a> /
            <a href="/movies/genres" class="font-light cursor-pointer">Genre</a> /
            <a href="{{route('movies.by-genre', $genre)}}" class="font-semibold cursor-pointer">{{$genre->name}}</a>
        </p>
        <livewire:movies.movies-by-genre :genre="$genre" />
    </div>

</x-layouts.app>
