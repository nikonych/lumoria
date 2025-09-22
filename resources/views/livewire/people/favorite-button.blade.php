<div>
    <button
        wire:click="toggleFavorite"
        class="group/btn rounded-full transition-all duration-300 cursor-pointer
               {{ Auth::check() ? ($isInFavorites ? $color : $inactiveColor . ' hover:' . $color) : $inactiveColor . ' cursor-not-allowed' }}"
        {{ !Auth::check() ? 'disabled' : '' }}
        title="{{ Auth::check() ? ($isInFavorites ? 'Aus Favoriten entfernen' : 'Zu Favoriten hinzufügen') : 'Anmelden um Film zu speichern' }}"
    >
        <svg class="{{ $size }} transition-all duration-300
                    {{ Auth::check() ? 'group-hover/btn:scale-110' : '' }}
                    {{ $isInFavorites ? 'fill-current' : 'fill-none' }}"
             stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
    </button>
</div>
