<div class="relative pb-5">
    <p class="mt-5 text-sm mb-1.5">Abteilung</p>
    <div class="grid grid-cols-4 gap-2">
        @foreach($this->departments as $department)
            <div class="flex items-center" wire:key="genre-{{ $department['value'] }}">
                <x-base.checkbox wire:model.live="form.selectedDepartments"
                                 value="{{ $department['value'] }}"
                                 label="{{ $department['text'] }}"
                                 id="genre-{{ $loop->index }}"/>
            </div>
        @endforeach
    </div>
    @error('form.selectedDepartments') <span
        class="absolute left-1 bottom-0 text-rot text-xs mt-2 block">{{ $message }}</span> @enderror
</div>
