@props(['genres'])


@if($genres && $genres->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12 mt-8">
        @foreach($genres as $genre)
            @php($movie = $genre->movies->first())

            @if($movie)
                <x-media-card
                    :title="$genre->name"
                    :imageUrl="$movie->poster_url"
                    :linkUrl="route('movies.by-genre', $genre)"
                />
            @endif
        @endforeach
    </div>
@endif
