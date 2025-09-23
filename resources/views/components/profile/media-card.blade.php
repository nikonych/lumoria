@props([
    'title',
    'count' => 0,
    'imageUrl',
    'linkUrl' => '#',
])

<a href="{{ $linkUrl }}" class="block relative p-4 bg-bg-card hover:bg-bg-card/50 rounded-lg text-left overflow-hidden group h-56">
    <h2 class="max-w-48 text-2xl font-semibold mb-2.5 text-white pt-12 ml-2">{{ $title }}
    </h2>
    <p class="text-indigo-300 text-sm ml-2 mb-4">{{$count}} Filme</p>
    <img src="{{ $imageUrl }}" alt="{{ $title }}"
         class="absolute bottom-[-64px] right-[-5px] w-42 h-62 rotate-[20deg] transform origin-bottom-right object-cover">
</a>
