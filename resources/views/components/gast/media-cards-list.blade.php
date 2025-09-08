<div class="grid grid-cols-3 gap-12 mt-8">
    <x-media-card
        title="Alle Filme anzeigen"
        imageUrl="{{ Vite::asset('resources/images/films/avatar.png') }}"
        linkUrl="/filme"
    />
    <x-media-card
        title="Genre"
        imageUrl="{{ Vite::asset('resources/images/films/alles.png') }}"
        linkUrl="/filme"
    />
    <x-media-card
        title="Neuerscheinungen"
        imageUrl="{{ Vite::asset('resources/images/films/nur_noch.png') }}"
        linkUrl="/filme"
    />
    <x-media-card
        title="Top - aktuell"
        imageUrl="{{ Vite::asset('resources/images/films/deadpool.png') }}"
        linkUrl="/filme"
    />
    <x-media-card
        title="Top - aller Zeiten"
        imageUrl="{{ Vite::asset('resources/images/films/shawshank.png') }}"
        linkUrl="/filme"
    />
    <x-media-card
        title="Ausgezeichnete Persönlichkeiten"
        imageUrl="{{ Vite::asset('resources/images/films/cillian.png') }}"
        linkUrl="/filme"
    />
</div>
