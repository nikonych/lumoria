@props([
    'movie' => null
])

<div class="flex flex-col overflow-hidden group">

    <div class="relative w-full overflow-hidden">
        <a class="cursor-pointer" href="{{route('movies.details', $movie)}}">
            @if(!empty($movie->poster_url))
                <img src="{{$movie->poster_url}}" alt="{{$movie->title}}"
                     class="w-full h-full object-cover rounded-sm">
            @else
                <img src="{{Vite::asset('resources/images/no_movie.svg')}}" alt="{{$movie->title}}"
                     class="w-full h-full object-cover rounded-sm">
            @endif
        </a>
        <div class="absolute top-2.5 right-2.5">
            @livewire('movies.watchlist-button', ['movie' => $movie, 'isOnlyIcon' => true])

        </div>
    </div>

    <div class="flex flex-col flex-grow py-3">
        <div class="flex-grow">
            <a class="cursor-pointer" href="{{route('movies.details', $movie)}}">
            <p class="text-indigo-300 line-clamp-1 cursor-pointer">{{$movie->title}}</p>
            </a>
        </div>

        @if (!empty($movie->genres))
            <p class="text-sm font-light text-slate-50 line-clamp-1 mt-auto pt-1">
                @foreach($movie->genres as $key => $genre)
                    <span>{{$genre->name}}</span>{{ !$loop->last ? ',' : '' }}
                @endforeach
            </p>
        @endif
    </div>
</div>
