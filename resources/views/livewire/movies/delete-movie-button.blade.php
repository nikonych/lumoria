<div>
    <x-base.button variant="danger" icon="trash" wire:click="confirmDelete">
        Löschen
    </x-base.button>

    @if($showConfirmModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4 text-red-600">Film löschen</h3>
                <p class="mb-6">Sind Sie sicher, dass Sie den Film "{{ $movie->title }}" löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.</p>

                <div class="flex justify-end space-x-2">
                    <button wire:click="$set('showConfirmModal', false)"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Abbrechen
                    </button>
                    <button wire:click="delete"
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Löschen
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
