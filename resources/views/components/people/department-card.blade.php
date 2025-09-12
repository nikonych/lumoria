@props([
    'title',
    'imageUrl',
    'linkUrl' => '#',
])

<a href="{{ $linkUrl }}" class="block relative p-4 bg-bg-card hover:bg-bg-card/50 rounded-lg text-left overflow-hidden group h-56">
    <h2 class="max-w-48 text-2xl font-semibold text-white mb-4 pt-12 ml-2">{{ $title }}
    </h2>
    <img src="{{ $imageUrl }}" alt="{{ $title }}"
         class="absolute bottom-[0px] right-[-5px] w-42 h-42 rotate-[0deg] transform origin-bottom-right object-cover">
</a>
