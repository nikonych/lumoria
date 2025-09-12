<div class="grid grid-cols-3 gap-12 mt-8">
    <x-media-card
        title="Alle Filme anzeigen"
        imageUrl="{{ Vite::asset('resources/images/movies/avatar.png') }}"
        linkUrl="/movies/all"
    />
    <x-media-card
        title="Genre"
        imageUrl="{{ Vite::asset('resources/images/movies/alles.png') }}"
        linkUrl="/movies/genres"
    />
    <x-media-card
        title="Neuerscheinungen"
        imageUrl="{{ Vite::asset('resources/images/movies/nur_noch.png') }}"
        linkUrl="/movies/new"
    />
    <x-media-card
        title="Top - aktuell"
        imageUrl="{{ Vite::asset('resources/images/movies/deadpool.png') }}"
        linkUrl="/movies/top-actual"
    />
    <x-media-card
        title="Top - aller Zeiten"
        imageUrl="{{ Vite::asset('resources/images/movies/shawshank.png') }}"
        linkUrl="/movies/top-actual"
    />
    <x-media-card
        title="Ausgezeichnete Persönlichkeiten"
        imageUrl="{{ Vite::asset('resources/images/movies/cillian.png') }}"
        linkUrl="/people/all"
    />
</div>
