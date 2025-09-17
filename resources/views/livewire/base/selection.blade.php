<div x-data="{
            open: false,
            direction: 'down',
            toggle() {
            this.open = ! this.open;
            if (this.open) {
                let rect = this.$el.getBoundingClientRect();
                let spaceBelow = window.innerHeight - rect.bottom;
                this.direction = (spaceBelow < 260 && rect.top > 260) ? 'up' : 'down';
                }
            }
            }"
     @click.outside="open = false"
     class="relative inline-block text-left {{ $class }}">
    <button @click="toggle()"
            type="button" class="inline-flex w-full font-light text-sm justify-between items-center gap-x-1.5 rounded-sm bg-input-dark px-3 py-1.5 focus:outline-none cursor-pointer">
        <span class="flex-grow text-left">{{ $this->selectedText }}</span>
        <svg x-bind:class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor" class="-mr-1 size-5 text-indigo-400 transition-transform duration-200">
            <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
        </svg>
    </button>

    <div
        x-show="open"
        x-transition
        :class="{
            'origin-top-right mt-2': direction === 'down',
            'origin-bottom-right bottom-full mb-2': direction === 'up'
        }"
        class="absolute right-0 z-10 w-full rounded-md bg-selection-bg ring-1 ring-white/10 shadow-lg"
        style="display: none;"
    >
        <div class="py-1 max-h-64 overflow-y-auto">
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
