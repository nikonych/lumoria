<div class="grid grid-cols-3 gap-12 mt-8">
    <x-people.department-card
        title="Alle Personen anzeigen"
        imageUrl="{{ Vite::asset('resources/images/departments/popcorn.svg') }}"
        linkUrl="/people/all"
    />
    <x-people.department-card
        title="Ausgezeichnete Persönlichkeiten"
        imageUrl="{{ Vite::asset('resources/images/departments/trophy.svg') }}"
        linkUrl="/people/with-awards"
    />
    <x-people.department-card
        title="Schauspieler"
        imageUrl="{{ Vite::asset('resources/images/departments/masks-theater.svg') }}"
        linkUrl="/people/actors"
    />
    <x-people.department-card
        title="Regie"
        imageUrl="{{ Vite::asset('resources/images/departments/clapperboard.svg') }}"
        linkUrl="/people/regisseurs"
    />
    <x-people.department-card
        title="Produktion"
        imageUrl="{{ Vite::asset('resources/images/departments/clipboard-list-check.svg') }}"
        linkUrl="/people/producers"
    />
    <x-people.department-card
        title="Drehbuch"
        imageUrl="{{ Vite::asset('resources/images/departments/Pen.svg') }}"
        linkUrl="/people/writers"
    />
    <x-people.department-card
        title="Musik"
        imageUrl="{{ Vite::asset('resources/images/departments/music.svg') }}"
        linkUrl="/people/musicians"
    />
    <x-people.department-card
        title="Kamera"
        imageUrl="{{ Vite::asset('resources/images/departments/camera-movie.svg') }}"
        linkUrl="/people/cameramen"
    />
    <x-people.department-card
        title="Schnitt"
        imageUrl="{{ Vite::asset('resources/images/departments/film.svg') }}"
        linkUrl="/people/editors"
    />
    <x-people.department-card
        title="Sonstige"
        imageUrl="{{ Vite::asset('resources/images/departments/users.svg') }}"
        linkUrl="/people/all"
    />
</div>
