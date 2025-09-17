@props([
    'value' => '',
    'id' => 'input-' . uniqid(),
    'name' => null,
    'placeholder' => '',
    'hasIcon' => false,
    'icon' => null,
    'type' => 'text',
    'label' => null
])

@php
    $name = $name ?? $id;
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" {{ $label->attributes->class(['block mb-1.5 text-sm text-slate-50']) }}>
            {{ $label }}
        </label>
    @endif

    <div class="relative group">
        @if($hasIcon)
            <div class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none">
                @if (isset($icon))
                    {{ $icon }}
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
            value="{{ $value }}"
            {{ $attributes->class([
                'w-full h-8 p-2 focus:outline-none placeholder:text-slate-50 font-light text-xs bg-input-dark focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500',
                'pl-7' => $hasIcon
            ]) }}
        />
    </div>
</div>
