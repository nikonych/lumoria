@props([
    'id' => 'input-' . uniqid(),
    'name' => null,
    'placeholder' => 'Search...',
    'hasIcon' => false,
    'iconSvg' => null,
    'type' => 'text',
])

@php
    $name = $name ?? $id;
@endphp

<div {{ $attributes->whereDoesntStartWith('wire:model')->class(['relative group h-full']) }}>

    @if ($hasIcon)
        <div class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none">
            @if ($iconSvg)
                {!! $iconSvg !!}
            @else
                <x-icons.search class="fill-slate-50 group-focus-within:fill-indigo-400"/>
            @endif
        </div>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->class([
            'w-full h-full p-2 focus:outline-none placeholder:text-slate-50 font-light text-xs bg-input-dark focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500',
            'pl-7' => $hasIcon
        ]) }}
    />
</div>
