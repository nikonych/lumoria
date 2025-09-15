<x-layouts.movie-index
    :title="$genre->name"
    :countries="$countries"
    :ageRatings="$ageRatings"
    :genres="$genres"
    :sortOptions="$sortOptions"
    :sortBy="$sortBy"
    :viewMode="$viewMode"
    :movies="$movies"
>
    @php
        $cardComponent = $viewMode === 'grid' ? 'movies.card' : 'movies.card-list';
    @endphp

    <div @class([
        'space-y-4' => $viewMode === 'list',
        'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8' => $viewMode === 'grid',
    ])>
        @foreach($movies as $movie)
            <x-dynamic-component :component="$cardComponent" :movie="$movie" />
        @endforeach
    </div>
</x-layouts.movie-index>
