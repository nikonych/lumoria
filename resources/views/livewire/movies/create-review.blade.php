<div class="flex flex-col w-2/3 bg-bg-card p-5 rounded-sm">

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-sm">
            {{ session('success') }}
        </div>
    @endif

    @error('general')
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-sm">
        {{ $message }}
    </div>
    @enderror

    <form wire:submit="submit">
        <div class="flex justify-between">
            <p class="text-2xl font-semibold">
                {{ $existingReview ? 'Ihre Bewertung bearbeiten:' : 'Deine Bewertung:' }}
            </p>
            <x-base.stars
                :rating="$rating"
                :movie_id="$movie->id"
                spacing="space-x-3"
                size="8"
                wire:click="updateRating"
                interactive="true"
            />
        </div>

        @error('rating')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <div class="mt-4">
            <x-base.input wire:model="title">
                <x-slot name="label">
                    Titel (optional)
                </x-slot>
            </x-base.input>
            @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4 flex flex-col flex-1 overflow-hidden min-h-0 rounded-sm">
            <x-base.input type="textarea" wire:model="description">
                <x-slot name="label">
                    Bewertung (optional)
                </x-slot>
            </x-base.input>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4 flex justify-end gap-3">
            @if ($existingReview)
                <x-base.button
                    type="button"
                    wire:click="deleteReview"
                    wire:confirm="Sind Sie sicher, dass Sie Ihre Bewertung löschen möchten?"
                    class="bg-red-500 hover:bg-red-600 text-white"
                >
                    Bewertung löschen
                </x-base.button>
                <x-base.button type="submit">
                    Bewertung aktualisieren
                </x-base.button>
            @else
                <x-base.button type="submit">
                    Bewertung abschicken
                </x-base.button>
            @endif
        </div>
    </form>
</div>
