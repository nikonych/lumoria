
@props([
    'name' => '',
    'label' => '',
    'wireModel' => '',
    'options' => [],
    'type' => 'search-select',
    'wrapperClass' => 'w-full',
    'containerClass' => 'relative pb-5',
    'modelClass' => null,
    'modelCreateField' => 'name'
])

<x-form.field :name="$name" :label="$label" :wrapper-class="$wrapperClass" :container-class="$containerClass">
    @if($type === 'search-select')
        <livewire:base.search-select
            :wire:model.blur="$wireModel"
            :options="$options"
            class="w-full"
            wire:key="search-select-{{ $name }}"
        />
    @elseif($type === 'search-select-with-add')
        <livewire:base.search-select-with-add
            wire:model.blur="{{ $wireModel }}"
            :options="$options"
            class="w-full"
            wire:key="selection-{{ $name }}"
            :modelClass="$modelClass"
            label="{{$label}}"
            :modelCreateField="$modelCreateField"
        />
    @else
        <livewire:base.selection
            :wire:model.blur="$wireModel"
            :options="$options"
            class="w-full"
            wire:key="selection-{{ $name }}"
        />
    @endif
</x-form.field>
