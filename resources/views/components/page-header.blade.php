@props([
    'title',
    'sortOptions' => [],
    'sortBy' => null,
    'viewMode' => null,
    'showSort' => true,
    'showViewSwitcher' => true
])

<div class="flex justify-between items-end">
    <h2 class="text-5xl">{{ $title }}</h2>

    <div class="flex gap-1.5 items-center">
        @if ($showSort)
            <p>Sortieren nach</p>
            <livewire:base.selection
                wire:model.live="sortBy"
                :options="$sortOptions"
                :select-first="true"
                class="w-auto"
            />
        @endif

        @if ($showViewSwitcher)
            <div class="flex items-center p-0.5 ml-3.5 bg-input-dark rounded-sm gap-1">
                <button wire:click="setView('grid')"
                    @class(['p-2 rounded-xs', 'bg-indigo-600 text-white' => $viewMode === 'grid', 'text-indigo-400 hover:bg-slate-700' => $viewMode !== 'grid'])>
                    <x-icons.grid/>
                </button>
                <button wire:click="setView('list')"
                    @class(['p-2 rounded-xs', 'bg-indigo-600 text-white' => $viewMode === 'list', 'text-indigo-400 hover:bg-slate-700' => $viewMode !== 'list'])>
                    <x-icons.list/>
                </button>
            </div>
        @endif
    </div>
</div>
