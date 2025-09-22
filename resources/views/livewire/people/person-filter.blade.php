<div class="space-y-6" wire:loading.class="opacity-50 pointer-events-none">

    <div>
        <label class="block text-sm font-medium">Geboren</label> <div class="flex items-center gap-2 mt-1">
            <x-base.input type="number" class="w-full" wire:model.blur="yearFrom" placeholder="" />
            <span>-</span>
            <x-base.input type="number" class="w-full" wire:model.blur="yearTo" placeholder="" />
        </div>
    </div>

    <div>
        <label for="nationality" class="block text-sm font-medium mb-1">Nationalität</label>
        <livewire:base.selection
            wire:model.live="nationalityId"
            :options="$nationalities->map(fn($n) => ['value' => $n->id, 'text' => $n->name])->toArray()"
            class="w-full"
        />
    </div>

    <div>
        <label for="country" class="block text-sm font-medium mb-1">Wohnort</label> <livewire:base.selection
            wire:model.live="countryId"
            :options="$countries->map(fn($c) => ['value' => $c->id, 'text' => $c->name])->toArray()"
            class="w-full"
        />
    </div>



    <div>
        <label for="language" class="block text-sm font-medium mb-1">Sprachen</label>
        <livewire:base.selection
            wire:model.live="languageId"
            :options="$languages->map(fn($l) => ['value' => $l->id, 'text' => $l->name])->toArray()"
            class="w-full"
        />
    </div>



    <fieldset>
        <legend class="text-sm font-medium">Abteilungen</legend>
        <div class="grid grid-cols-1 gap-x-4 gap-y-2 mt-2">
            @foreach($departments as $department)
                <div class="flex items-center">
                    <x-base.checkbox
                        wire:model.live="selectedDepartments"
                        value="{{ $department->id }}"
                        label="{{ $department->name }}"
                        id="department-{{ $loop->index }}"
                    />
                </div>
            @endforeach
        </div>
    </fieldset>

    <div class="flex items-center gap-4 pt-4">
        <button wire:click="resetFilters" class="w-full bg-gray-600/50 hover:bg-gray-500/50 text-white font-semibold py-2 px-4 rounded-md transition-colors">
            Zurücksetzen
        </button>
    </div>
</div>
