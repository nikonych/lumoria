<div class="space-y-6">
    <div>
        <label for="country" class="block text-sm font-medium mb-1">Produktionsland</label>
        <livewire:base.selection
            wire:model.live="countryId"
            :options="$countries"
            label="Alle Länder"
            class="w-full"
        />
    </div>

    <div>
        <label class="block text-sm font-medium">Erscheinungsjahr</label>
        <div class="flex items-center gap-2 mt-1">
            <x-base.input type="number" class="w-full" wire:model.blur="yearFrom" />
            <span>-</span>
            <x-base.input type="number" class="w-full" wire:model.blur="yearTo" />
        </div>
    </div>

    <div>
        <h4 class="text-sm font-medium">Altersfreigabe</h4>
        <div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-2">
            @foreach($ageRatings as $rating)
                <div class="flex items-center">
                    <x-base.checkbox wire:model.live="selectedAgeRatings" value="{{ $rating }}" label="{{ $rating }}" id="age-rating-{{ $loop->index }}" />
                </div>
            @endforeach
        </div>
    </div>

    <div>
        <h4 class="text-sm font-medium">Genre</h4>
        <div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-2">
            @foreach($genres as $genre)
                <div class="flex items-center">
                    <x-base.checkbox wire:model.live="selectedGenres" value="{{ $genre->id }}" label="{{ $genre->name }}" id="genre-{{ $loop->index }}" />
                </div>
            @endforeach
        </div>
    </div>

    <div>
        <h4 class="text-sm font-medium text-gray-300">Bewertungen</h4>
        <div class="space-y-2 mt-2">
            <x-base.radio-with-stars wire:model.live="selectedRating" value="4" label="4 und mehr" :stars="4" id="rating-4-stars" />
            <x-base.radio-with-stars wire:model.live="selectedRating" value="3" label="3 und mehr" :stars="3" id="rating-3-stars" />
            <x-base.radio-with-stars wire:model.live="selectedRating" value="2" label="2 und mehr" :stars="2" id="rating-2-stars" />
            <x-base.radio-with-stars wire:model.live="selectedRating" value="1" label="1 und mehr" :stars="1" id="rating-1-stars" />
        </div>
    </div>

    <div class="flex items-center gap-4 pt-4">
        <button wire:click="resetFilters" class="w-full bg-gray-600/50 hover:bg-gray-500/50 text-white font-semibold py-2 px-4 rounded-md transition-colors">
            Zurücksetzen
        </button>
    </div>
</div>
