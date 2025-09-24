<div class="flex gap-16">
    <div class="w-2/3 pb-5">
        <h2 class="text-5xl">Hallo {{auth()->user()->name ?? 'Filmfreund'}}!</h2>
        <x-home.media-cards-list/>
        @livewire('movies.movie-list', [
            'type' => 'recommendations',
            'title' => 'Deine Empfehlungen'
        ])
        @livewire('movies.movie-list', [
            'type' => 'watchlist',
            'title' => 'Deine Watchlist'
        ])
    </div>
    <div class="w-1/3">
        <livewire:home.friends-activity/>
    </div>
</div>
