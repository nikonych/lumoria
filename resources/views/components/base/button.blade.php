@props([
    'href' => null,
    'icon' => null,
    'iconPosition' => 'right',
    'variant' => 'primary'
])

@php
    $tag = $href ? 'a' : 'button';
    $isIconOnly = $icon && $slot->isEmpty();

    $variants = [
        'primary' => 'bg-indigo-700 text-slate-50 hover:bg-indigo-600',
        'secondary' => 'bg-bg-secondary text-slate-200 hover:bg-slate-600',
        'danger' => 'bg-rot text-white hover:bg-red-500',
    ];

    $variantClasses = $variants[$variant] ?? $variants['primary'];

    $attributes = $attributes->class([
        'inline-flex cursor-pointer items-center justify-center gap-2 transition-colors font-light rounded-sm',
        $variantClasses,
        'w-8 h-8' => $isIconOnly,
        'px-4 py-1.5 text-sm' => !$isIconOnly,
        'flex-row-reverse' => $iconPosition === 'right'
    ]);
@endphp

<{{ $tag }} @if($href) href="{{ $href }}" @endif {{ $attributes }}>
@if ($icon)
    <x-dynamic-component
        :component="'icons.' . $icon"
        @class([
            'w-4 h-4' => !$isIconOnly,
            'w-5 h-5' => $isIconOnly,
        ])
    />
@endif

@if (!$isIconOnly)
    <span>{{ $slot }}</span>
@endif
</{{ $tag }}>
