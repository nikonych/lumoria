@props([
    'existingPhotos' => [],
    'newPhotos' => [],
    'wireModel' => 'newPhotos',
    'title' => 'Fotos hinzufügen'
])

<x-form.photo-gallery
    :existing-photos="$existingPhotos"
    :new-photos="$newPhotos"
    :wire-model="$wireModel"
    :title="$title"
/>
