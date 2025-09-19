@props([
    'movie' => null
])

<div class="flex flex-col w-48 rounded-sm overflow-hidden group">

    <div class="relative w-full rounded-sm overflow-hidden">
        <a class="cursor-pointer" href="{{route('movies.details', $movie)}}">
        <img src="{{$movie->poster_url}}" alt="{{$movie->title}}"
             class="w-full h-full object-cover">
        </a>
        <x-base.button class="absolute top-2.5 right-2.5" icon="plus"/>
    </div>

    <div class="flex flex-col flex-grow py-3">
        <div class="flex-grow">
            <a class="cursor-pointer" href="{{route('movies.details', $movie)}}">
            <p class="text-indigo-300 text-lg line-clamp-2 h-13 cursor-pointer">{{$movie->title}}</p>
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
