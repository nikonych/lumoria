@props([
    'value' => '',
    'id' => 'textarea-' . uniqid(),
    'name' => null,
    'placeholder' => '',
    'label' => null
])

@php
    $name = $name ?? $id;
@endphp

<div {{ $attributes->class(['flex flex-col h-full']) }}>
    @if ($label)
        <label for="{{ $id }}" {{ $label->attributes->class(['block mb-1.5 text-sm text-slate-50 flex-shrink-0']) }}>
            {{ $label }}
        </label>
    @endif

    <div class="relative group grow">
        <textarea
            id="{{ $id }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            class="w-full h-full p-2 focus:outline-none placeholder:text-slate-50 font-light text-xs bg-input-dark focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500"
        >{{ $value }}</textarea>
    </div>
</div>
