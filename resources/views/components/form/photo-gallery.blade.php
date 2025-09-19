@props([
    'photos' => [],
    'wireModel' => 'photos',
    'title' => 'Fotos hinzufügen'
])

<div class="mt-16">
    <p class="text-2xl mb-5">{{ $title }}</p>

    <div
        class="bg-input-dark flex relative rounded-sm p-6 hover:bg-slate-700 transition-colors duration-200 min-h-[200px]"
        x-data="{
            isDragging: false,
            handleDrop(e) {
                this.isDragging = false;
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const input = document.getElementById('photoUpload');
                    input.files = files;
                    input.dispatchEvent(new Event('change'));
                }
            }
        }"
        x-on:dragover.prevent="isDragging = true"
        x-on:dragleave.prevent="isDragging = false"
        x-on:drop.prevent="handleDrop"
        :class="{ 'bg-slate-600': isDragging }"
    >
        <!-- Фотографии слева -->
        @if ($photos && count($photos) > 0)
            <div class="flex-1 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 pr-6">
                @foreach ($photos as $index => $photo)
                    <div class="relative aspect-square group">
                        <img src="{{ $photo->temporaryUrl() }}"
                             class="object-cover w-full h-full rounded-md border-2 border-slate-500"
                             alt="Preview">

                        <!-- Информация о файле при наведении -->
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-80 text-white text-xs p-1 rounded-b-md opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <p class="truncate text-center">{{ number_format($photo->getSize() / 1024, 0) }}KB</p>
                        </div>

                        <!-- Кнопка удаления -->
                        <button type="button"
                                wire:click="removePhoto({{ $index }})"
                                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg"
                                title="Foto entfernen">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Зона загрузки справа -->
        <div class="flex flex-col items-center justify-center space-y-3 {{ $photos && count($photos) > 0 ? 'min-w-[200px]' : 'flex-1' }} transition-all duration-300">
            <!-- Иконка и текст -->
            <div class="flex flex-col items-center space-y-2">
                <div class="p-3">
                    <x-icons.inbox-in class="w-8 h-8"/>
                </div>

                @if ($photos && count($photos) > 0)
                    <p class="text-slate-400 text-sm font-light text-center">Weitere Fotos<br>hinzufügen</p>
                    <div class="text-xs text-slate-500 text-center">
                        <span class="bg-slate-700 px-2 py-1 rounded">{{ count($photos) }} {{ count($photos) === 1 ? 'Foto' : 'Fotos' }}</span>
                    </div>
                @else
                    <p class="text-slate-400 text-sm font-light text-center">Dateien hierher ziehen</p>
                    <p class="text-slate-400 text-sm font-light">oder</p>
                @endif
            </div>

            <!-- Кнопка загрузки -->
            <label for="photoUpload" class="cursor-pointer">
                <span class="bg-bg-secondary hover:bg-slate-600 text-xs py-2.5 px-4 rounded-md transition-colors duration-200 block text-center">
                    {{ $photos && count($photos) > 0 ? '+ Weitere Fotos' : 'Dateien durchsuchen' }}
                </span>
            </label>
        </div>

        <!-- Скрытый input -->
        <input type="file" id="photoUpload" class="hidden" wire:model.live="{{ $wireModel }}" multiple accept="image/*">

        <!-- Индикатор загрузки -->
        <div wire:loading wire:target="{{ $wireModel }}" class="absolute inset-0 bg-slate-800 bg-opacity-75 flex items-center justify-center rounded-sm">
            <div class="flex items-center space-x-3 text-white">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
                <span class="text-sm">Fotos werden hochgeladen...</span>
            </div>
        </div>
    </div>

    <!-- Ошибки -->
    @error($wireModel)
    <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
    @enderror

    @error($wireModel . '.*')
    <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
    @enderror

    <!-- Подсказка -->
    @if ($photos && count($photos) > 0)
        <div class="mt-3 text-xs text-slate-500 flex items-center justify-between">
            <span>💡 Tipp: Klicken Sie auf ein Foto, um Details zu sehen</span>
            <button type="button"
                    wire:click="clearAllPhotos"
                    wire:confirm="Alle Fotos löschen?"
                    class="text-red-400 hover:text-red-300 text-xs underline">
                Alle löschen
            </button>
        </div>
    @endif
</div>
