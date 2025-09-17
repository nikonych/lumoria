<div x-data="{ open: false }" @click.outside="open = false" class="relative inline-block text-left {{ $class }}">
    <div class="relative">
        <input
            type="text"
            wire:model.live.debounce.300ms="searchTerm"
            @focus="open = true"
            placeholder="{{ $label }}"
            class="inline-flex w-full font-light text-sm justify-between items-center gap-x-1.5 rounded-sm bg-input-dark px-3 py-1.5 focus:outline-none focus:ring-1 focus:ring-indigo-500 cursor-pointer @if($icon) pr-10 @endif"
        >
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            @if($icon)
                <x-dynamic-component :component="'icons.' . $icon" class="size-5 text-gray-400 mr-2"/>
            @endif
            <svg x-bind:class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor" class="-mr-1 size-5 text-indigo-400 transition-transform duration-200">
                <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
            </svg>
        </div>
    </div>

    <div
        x-show="open"
        x-transition
        class="absolute right-0 z-10 mt-2 w-full rounded-md bg-selection-bg ring-1 ring-white/10 shadow-lg origin-top-right"
        style="display: none;"
    >
        <div class="py-1 max-h-64 overflow-y-auto">
            @forelse ($this->filteredOptions as $option)
                <a href="#"
                   wire:click.prevent="selectOption('{{ $option['value'] }}')"
                   @click="open = false"
                   class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">
                    {{ $option['text'] }}
                </a>
            @empty
                <span class="block px-4 py-2 text-sm text-gray-500">nichts gefunden</span>
            @endforelse
        </div>
    </div>
</div>
