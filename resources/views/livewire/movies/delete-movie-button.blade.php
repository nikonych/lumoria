<div>
    <x-base.button variant="danger" icon="trash" wire:click="confirmDelete">
        Löschen
    </x-base.button>

    @if($showConfirmModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="rounded-lg flex flex-col justify-center items-center bg-slate-900 p-6 max-w-md w-full mx-4">
                <h3 class="text-3xl font-semibold mb-4">Bist du dir sicher?</h3>
                <p class="text-center font-light text-sm">Möchtest du {{ $movie->title }} dauerhaft löschen? Diese Aktion kann nicht rückgängig gemacht werden.</p>

                <div class="flex justify-between space-x-2 mt-6 w-full">
                    <x-base.button wire:click="$set('showConfirmModal', false)" variant="secondary" class="w-1/2">
                        Abbrechen
                    </x-base.button>
                    <x-base.button variant="danger" wire:click="delete" class="w-1/2">
                        Löschen
                    </x-base.button>
                </div>
            </div>
        </div>
    @endif
</div>
