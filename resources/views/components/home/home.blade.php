<div class="flex gap-16">
    <div class="w-2/3">
        <h2 class="text-5xl">Hallo {{auth()->user()->name}}!</h2>
        <x-home.media-cards-list/>
        <x-home.film-carousel title="Deine Empfehlungen"/>
        <x-home.film-carousel title="Deine Watchlist"/>
    </div>
    <div class="w-1/3">
        <x-home.activity/>
    </div>
</div>
