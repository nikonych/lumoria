@props([
    'hasIcon' => false
])

<div {{ $attributes->only('class')->merge(['class' => 'relative group h-full']) }}>

    @if ($hasIcon)
        <div class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none">
            {{ $icon }}
        </div>
    @endif

    <input {{ $attributes->except('class')->merge([
        'class' => 'w-full h-full p-2 focus:outline-none placeholder:text-slate-50 font-light text-xs bg-input-dark focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500' . ($hasIcon ? ' pl-7' : '')
    ]) }}
    >
</div>
