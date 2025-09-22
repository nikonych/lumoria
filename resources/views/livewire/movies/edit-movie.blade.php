<div>
    <div class="mb-16">

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

        <form wire:submit="save">
            @include('livewire.movies.create.movie-information-manager')

            @include('livewire.movies.create.genre-manager')

            @include('livewire.movies.create.photo-manager', [
            'existingPhotos' => $existingPhotos,
            'newPhotos' => $newPhotos
            ])

            @include('livewire.movies.create.cast-manager')

            @include('livewire.movies.create.crew-manager')

            @include('livewire.movies.create.award-manager')

            <div class="flex justify-end items-center mt-16">


                <div class="flex space-x-3">
                    <x-base.button type="button" variant="secondary" href="{{ route('movies.index', $movie) }}">
                        Abbrechen
                    </x-base.button>
                    <x-base.button type="submit">
                        Änderungen speichern
                    </x-base.button>
                </div>
            </div>
        </form>
    </div>

    <div wire:loading wire:target="save"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Film wird gespeichert...</span>
        </div>
    </div>
</div>
