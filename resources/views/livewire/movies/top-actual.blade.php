<div>
    <div class="flex justify-between items-end">
        <h2 class="text-5xl mt-8">Top - aktuell</h2>
        <div class="flex gap-1.5 items-center">
            <p class="">Sortieren nach</p>

            <livewire:base.selection
                wire:model.live="sortBy"
                :options="$sortOptions"
                :select-first="true"
                class="w-40"
            />
        </div>
    </div>

    <div class="mt-10">
        <div class="space-y-2.5 mb-2.5">
            @foreach($movies as $movie)
                <x-movies.card-list :movie="$movie" :rank="$loop->iteration"/>
            @endforeach
        </div>

    </div>
</div>
