@props([
    'href' => null,
    'icon' => null,
    'iconPosition' => 'right'
])

@php
    $tag = $href ? 'a' : 'button';
    $isIconOnly = $icon && $slot->isEmpty();

    $attributes = $attributes->class([
        'inline-flex items-center justify-center gap-2 transition-colors',
        'bg-indigo-700 text-slate-50 hover:bg-indigo-600 rounded-sm',
        'w-8 h-8' => $isIconOnly,
        'px-4 py-2 text-sm' => !$isIconOnly,
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
