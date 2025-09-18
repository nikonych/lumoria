
@props([
    'name' => '',
    'label' => '',
    'error' => null,
    'wrapperClass' => 'w-full',
    'containerClass' => 'relative pb-5'
])

@php
    $errorMessage = $error ?? $errors->first($name);
@endphp

<div class="{{ $containerClass }}">
    @if($label)
        <label class="block mb-1.5 text-sm text-slate-50">{{ $label }}</label>
    @endif

    <div class="{{ $wrapperClass }}">
        {{ $slot }}
    </div>

    @if($errorMessage)
        <span class="absolute left-1 bottom-0 text-red-500 text-xs">{{ $errorMessage }}</span>
    @endif
</div>
