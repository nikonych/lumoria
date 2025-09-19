<div>
    <x-base.button
        icon="plus"
        wire:click="toggleWatchlist"
        class="{{ $isInWatchlist ? 'bg-green-500 text-white' : '' }}"
    >
        {{ $isInWatchlist ? 'In Watchlist' : 'Watchlist' }}
    </x-base.button>

    @if (session()->has('watchlist-message'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50"
             x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 3000)">
            {{ session('watchlist-message') }}
        </div>
    @endif
</div>
