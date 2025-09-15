@props([
    'person' => null,
    ]
)

<div class="flex bg-bg-card rounded-lg p-4 group pr-6">

    <div @class([
                'flex-shrink-0',
                'content-center',
                'ml-2',
        ])>
        <a class="cursor-pointer" href="{{route('people.details', $person)}}">
            <img src="{{ $person->profile_image }}"
                 alt="{{ $person->name }}"
                 class="w-15 h-15 object-cover rounded-xs">
        </a>
    </div>

    <div class="flex ml-6 items-center">
        <a class="cursor-pointer" href="{{route('people.details', $person)}}">
            <h3 class="text-2xl font-semibold">
                {{ $person->name }}
            </h3>
        </a>

    </div>
    <div class="flex-1 content-center ml-4 space-x-2.5">
        @foreach($person->departments as $department)
            <span class="bg-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-sm">
                {{ $department->name }}
            </span>
        @endforeach
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col items-end justify-center gap-3 ml-6">
        @auth
            <div class="flex items-center gap-5">
                <button
                    class="group/btn rounded-full cursor-pointer transition-all duration-300 {{ $person->is_favorite ? 'text-pink-400' : 'text-gray-400 hover:text-pink-400' }}"
                    data-movie-id="{{ $person->id }}"
                    data-favorite="{{ $person->is_favorite ? 'true' : 'false' }}"
                >
                    <svg class="w-12 h-12 text-indigo-700 hover:text-indigo-600"
                         fill="{{ $person->is_favorite ? 'currentColor' : 'none' }}"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>

            </div>
        @endauth
        @guest
            <div class="flex items-center gap-5">
                <button
                    class="group/btn rounded-full transition-all duration-300 text-gray-400 }}"
                    data-movie-id="{{ $person->id }}"
                    disabled
                >
                    <svg class="w-12 h-12 text-gray-700"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>

            </div>
        @endguest
    </div>
</div>

