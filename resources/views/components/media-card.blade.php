@props([
    'title',
    'imageUrl',
    'linkUrl' => '#',
])

<a href="{{ $linkUrl }}" class="block relative p-4 bg-bg-card hover:bg-bg-card/50 rounded-lg text-left overflow-hidden group h-56">
    <h2 class="max-w-48 text-2xl font-semibold text-white mb-4 pt-12 mx-9">{{ $title }}</h2>

    <img src="{{ $imageUrl }}" alt="{{ $title }}"
         class="absolute bottom-[-64px] right-[55px] w-42 h-62 rotate-[20deg] transform origin-bottom-right object-cover">
</a>
