
@props([
    'name' => '',
    'label' => '',
    'wireModel' => '',
    'type' => 'text',
    'hasIcon' => false,
    'icon' => null,
    'wrapperClass' => 'w-full',
    'containerClass' => 'relative pb-5',
    'updateOn' => 'blur'
])

<x-form.field :name="$name" :label="$label" :wrapper-class="$wrapperClass" :container-class="$containerClass">
    @if($updateOn === 'live')
        <x-base.input
            type="{{ $type }}"
            wire:model.live="{{ $wireModel }}"
            :has-icon="$hasIcon">

            @if($hasIcon && $icon)
                <x-slot name="icon">
                    <x-dynamic-component :component="'icons.' . $icon" />
                </x-slot>
            @endif
        </x-base.input>
    @elseif($updateOn === 'lazy')
        <x-base.input
            type="{{ $type }}"
            wire:model.lazy="{{ $wireModel }}"
            :has-icon="$hasIcon">

            @if($hasIcon && $icon)
                <x-slot name="icon">
                    <x-dynamic-component :component="'icons.' . $icon" />
                </x-slot>
            @endif
        </x-base.input>
    @else
        <x-base.input
            type="{{ $type }}"
            wire:model.blur="{{ $wireModel }}"
            :has-icon="$hasIcon">

            @if($hasIcon && $icon)
                <x-slot name="icon">
                    <x-dynamic-component :component="'icons.' . $icon" />
                </x-slot>
            @endif
        </x-base.input>
    @endif
</x-form.field>
