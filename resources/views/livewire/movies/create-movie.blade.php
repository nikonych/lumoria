<div class="mb-16">
    <form wire:submit="save">

        @include('livewire.movies.create.movie-information-manager')
        @include('livewire.movies.create.genre-manager')


        @include('livewire.movies.create.photo-manager')

        @include('livewire.movies.create.cast-manager')
        @include('livewire.movies.create.crew-manager')


        @include('livewire.movies.create.award-manager')


        <div class="flex justify-end mt-16 space-x-5">
            <x-base.button type="button" variant="secondary">
                Abbrechen
            </x-base.button>
            <x-base.button type="submit">
                Film hinzufügen
            </x-base.button>
        </div>
    </form>
</div>
