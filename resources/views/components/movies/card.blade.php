@props([
    'movie' => null
])

<div class="flex flex-col w-48 rounded-sm overflow-hidden group">

    <div class="relative w-full rounded-sm overflow-hidden">
        <a class="cursor-pointer" href="{{route('movies.details', $movie)}}">
        <img src="{{$movie->poster_image}}" alt="{{$movie->title}}"
             class="w-full h-full object-cover">
        </a>
        <button class="absolute top-2.5 right-2.5 bg-indigo-700 hover:bg-indigo-600 p-3.5 cursor-pointer rounded-md">
            <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.125 5.5C10.125 5.82812 9.86719 6.0625 9.5625 6.0625H5.8125V9.8125C5.8125 10.1406 5.55469 10.3984 5.25 10.3984C4.92188 10.3984 4.6875 10.1406 4.6875 9.8125V6.0625H0.9375C0.609375 6.0625 0.375 5.82812 0.375 5.52344C0.375 5.19531 0.609375 4.9375 0.9375 4.9375H4.6875V1.1875C4.6875 0.882812 4.92188 0.648438 5.25 0.648438C5.55469 0.648438 5.8125 0.882812 5.8125 1.1875V4.9375H9.5625C9.86719 4.9375 10.125 5.19531 10.125 5.5Z" fill="white"/>
            </svg>
        </button>
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
