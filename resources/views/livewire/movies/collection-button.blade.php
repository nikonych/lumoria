<div>
    <x-base.button icon="directory" wire:click="openCollectionModal">
        Sammlung
    </x-base.button>

    @if($showCollectionModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="rounded-lg bg-slate-900 p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4">Film zu Sammlung hinzufügen</h3>

                {{-- Существующие коллекции --}}
                <div class="space-y-2 mb-4">
                    @foreach($userCollections as $collection)
                        <div class="flex items-center" wire:key="collection-{{ $collection['id'] }}">
                            <x-base.checkbox-profile
                                wire:model.live="selectedCollections"
                                value="{{ $collection['id'] }}"
                                label="{{ $collection['name'] }}"
                                id="genre-{{ $collection['id'] }}"
                                :checked="in_array($collection['id'], $this->selectedCollections ?? [])"
                            />
                        </div>
                    @endforeach
                </div>


                {{-- Buttons --}}
                <div class="flex justify-end space-x-2">
                    <button wire:click="closeCollectionModal"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Abbrechen
                    </button>
                    <button wire:click="updateMovieCollections"
                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Speichern
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('collection-message'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50"
             x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 3000)">
            {{ session('collection-message') }}
        </div>
    @endif
</div>
