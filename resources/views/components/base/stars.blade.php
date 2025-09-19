@props([
    'rating' => 0,
    'movie_id' => uniqid(),
    'size' => 7,
    'spacing' => "space-x-1",
    'color' => 'text-indigo-600',
    'interactive' => false,
    'wireClick' => null
])

<div class="flex items-center {{ $spacing }}"
     @if($interactive)
         x-data="{ hoverRating: 0, currentRating: {{ $rating }} }"
     @mouseleave="hoverRating = 0"
    @endif
>
    @for ($i = 1; $i <= 5; $i++)
        @php
            $state = 'empty';
            if ($i <= floor($rating)) {
                $state = 'full';
            } elseif ($i == ceil($rating) && $rating - floor($rating) >= 0.5) {
                $state = 'half';
            }
        @endphp

        <div class="{{ $color }} {{ $interactive ? 'cursor-pointer hover:scale-110 transition-transform' : '' }}"
             @if($interactive)
                 @mouseenter="hoverRating = {{ $i }}"
             wire:click="updateRating({{ $i }})"
             :class="{ 'opacity-50': hoverRating > 0 && hoverRating < {{ $i }} }"
            @endif
        >
            @if ($state === 'full')
                <x-icons.star-full :size="$size" :movie_id="$movie_id"/>
            @elseif ($state === 'half')
                <x-icons.star-half :size="$size" :i="$i"/>
            @else
                <x-icons.star-empty :size="$size" :movie_id="$movie_id"/>
            @endif
        </div>
    @endfor
</div>
