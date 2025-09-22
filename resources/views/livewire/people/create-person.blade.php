<div class="mb-16">
    <form wire:submit="save">

        @include('livewire.people.create.person-information-manager')


        @include('livewire.people.create.photo-manager')

        @include('livewire.people.create.biography-manager')

        @include('livewire.people.create.cast-manager')
        @include('livewire.people.create.crew-manager')


        @include('livewire.people.create.award-manager')


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
