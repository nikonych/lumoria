@props([
    'name' => 'image',
    'label' => 'Bild hochladen',
    'wireModel' => '',
    'currentImage' => null,
    'aspectRatio' => 'aspect-[3/5]',
    'acceptedFormats' => '.jpg, .png',
    'wrapperClass' => ''
])

<div class="{{ $wrapperClass }}">
    @if($label)
        <p class="font-medium text-sm mb-1.5">{{ $label }}</p>
    @endif

    <div
        x-data="{
            dragover: false,
            handleDrop(e) {
                e.preventDefault();
                this.dragover = false;
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const file = files[0];
                    if (file.type.startsWith('image/')) {
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        document.getElementById('{{ $name }}Upload').files = dt.files;
                        document.getElementById('{{ $name }}Upload').dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            }
        }"
        @drop="handleDrop($event)"
        @dragover.prevent="dragover = true"
        @dragleave.prevent="dragover = false"
        @click="document.getElementById('{{ $name }}Upload').click()"
        class="{{ $aspectRatio }} bg-input-dark flex hover:bg-slate-700 items-center transition-colors duration-200 justify-center relative rounded-sm cursor-pointer"
        :class="dragover ? 'border-indigo-500 bg-slate-600' : 'border-slate-600'">

        @if ($currentImage)
            <img src="{{ $currentImage->temporaryUrl() }}"
                 class="object-cover h-full w-full rounded-sm"
                 alt="{{ $label }}">
        @else
            <div class="text-center">
                <div class="text-slate-500 mb-2">
                    <x-icons.image/>
                </div>
            </div>
        @endif

        <!-- Loading overlay -->
        <div wire:loading wire:target="{{ $wireModel }}"
             class="absolute inset-0 bg-slate-800 bg-opacity-75 flex items-center justify-center rounded-sm">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
        </div>
    </div>

    <input type="file"
           id="{{ $name }}Upload"
           class="hidden"
           wire:model="{{ $wireModel }}"
           accept="image/*">

    @error($wireModel)
    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
    @enderror

    <div class="flex mt-3.5 space-x-2.5 items-center justify-between">
        <x-base.button type="button"
                       variant="secondary"
                       onclick="document.getElementById('{{ $name }}Upload').click()"
                       class="w-3/5 text-xs py-2.5 px-4 rounded-md">
            Datei hochladen
        </x-base.button>
        <p class="text-xs w-2/5 text-slate-500 text-center">{{ $acceptedFormats }}</p>
    </div>
</div>
