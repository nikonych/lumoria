@props([
    'label' => null,
    'value' => '',
    'id' => 'input-' . uniqid(),
    'name' => null,
    'placeholder' => '',
    'hasIcon' => false,
    'iconSvg' => null,
    'type' => 'text',
])

@php
    $name = $name ?? $id;
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" {{ $label->attributes->class(['block mb-1 text-sm font-medium text-gray-300']) }}>
            {{ $label }}
        </label>
    @endif

    <div {{ $attributes->whereDoesntStartWith('wire:model')->class(['relative group h-full']) }}>
        @if($hasIcon)
            <div class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none">
                @if ($iconSvg)
                    {!! $iconSvg !!}
                @else
                    <x-icons.search class="fill-slate-50 group-focus-within:fill-indigo-400"/>
                @endif
            </div>
        @endif

        @if ($type === 'textarea')
            <textarea
                id="{{ $id }}"
                name="{{ $name }}"
                placeholder="{{ $placeholder }}"
                {{ $attributes->class([
                    'w-full h-full p-2 focus:outline-none placeholder:text-slate-50 font-light text-xs bg-input-dark focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500',
                    'pl-7' => $hasIcon
                ]) }}
            >{{ $value }}</textarea>
        @else
            <input
                type="{{ $type }}"
                id="{{ $id }}"
                name="{{ $name }}"
                placeholder="{{ $placeholder }}"
                value="{{ $value }}"
                {{ $attributes->class([
                    'w-full h-full p-2 focus:outline-none placeholder:text-slate-50 font-light text-xs bg-input-dark focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500',
                    'pl-7' => $hasIcon
                ]) }}
            />
        @endif
    </div>
</div>
