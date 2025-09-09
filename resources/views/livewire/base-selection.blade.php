<div x-data="{ open: false }" @click.outside="open = false" class="relative inline-block text-left">
    <button @click="open = !open" type="button" class="inline-flex w-full font-light text-sm justify-center items-center gap-x-1.5 rounded-md bg-input-dark px-3 py-1.5 focus:outline-none cursor-pointer">
        {{ $this->selectedText }}
        <svg x-bind:class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor" class="-mr-1 ml-8 size-5 text-indigo-400 transition-transform duration-200">
            <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
        </svg>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-input-dark ring-1 ring-white/10 shadow-lg"
        style="display: none;"
    >
        <div class="py-1">
            @foreach ($options as $option)
                <a href="#"
                   wire:click.prevent="selectOption('{{ $option['value'] }}')"
                   @click="open = false"
                   class="block px-4 py-2 text-sm hover:bg-white/5 hover:text-white">
                    {{ $option['text'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>
