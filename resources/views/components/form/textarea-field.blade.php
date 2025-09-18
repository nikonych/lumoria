@props([
    'name' => '',
    'label' => '',
    'wireModel' => '',
    'wrapperClass' => 'w-full',
    'containerClass' => 'relative pb-5',
    'updateOn' => 'blur',
    'rows' => 7
])

<x-form.field :name="$name" :label="$label" :wrapper-class="$wrapperClass" :container-class="$containerClass">
    @if($updateOn === 'live')
        <textarea
            wire:model.live="{{ $wireModel }}"
            rows="{{ $rows }}"
            {{ $attributes->merge(['class' => 'w-full px-3 py-2 text-slate-50 bg-input-dark  rounded-md focus:outline-none ']) }}
        ></textarea>
    @elseif($updateOn === 'lazy')
        <textarea
            wire:model.lazy="{{ $wireModel }}"
            rows="{{ $rows }}"
            {{ $attributes->merge(['class' => 'w-full px-3 py-2 text-slate-50 bg-input-dark  rounded-md focus:outline-none ']) }}
        ></textarea>
    @else
        <textarea
            wire:model.blur="{{ $wireModel }}"
            rows="{{ $rows }}"
            {{ $attributes->merge(['class' => 'w-full px-3 py-2 text-slate-50 bg-input-dark  rounded-md focus:outline-none ']) }}
        ></textarea>
    @endif
</x-form.field>
