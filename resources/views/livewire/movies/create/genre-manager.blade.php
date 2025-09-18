<div class="relative pb-5">
    <p class="mt-5 text-sm mb-1.5">Genre</p>
    <div class="grid grid-cols-8">
        @foreach($genres as $genre)
            <div class="flex items-center" wire:key="genre-{{ $genre->id }}">
                <x-base.checkbox wire:model.live="form.selectedGenres"
                                 value="{{ $genre->id }}"
                                 label="{{ $genre->name }}"
                                 id="genre-{{ $loop->index }}"/>
            </div>
        @endforeach
    </div>
    @error('form.selectedGenres') <span
        class="absolute left-1 bottom-0 text-rot text-xs mt-2 block">{{ $message }}</span> @enderror
</div>
