@props([
    'hasIcon' => false,
    'id' => 'input-' . uniqid(),
    'type' => 'text'
])

<div {{ $attributes->only('class')->merge(['class' => 'w-full h-full']) }}>

    @if (isset($label))
        <label for="{{ $id }}" class="block mb-1.5 text-sm">
            {{ $label }}
        </label>
    @endif

    <div class="relative group h-full rounded-sm overflow-hidden">

        @if ($hasIcon)
            <div class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none">
                {{ $icon }}
            </div>
        @endif

        {{-- Новая логика: рендерим textarea или input в зависимости от type --}}
        @if ($type === 'textarea')
            <textarea
                id="{{ $id }}"
                {{ $attributes->except('class')->merge([
                    'class' => 'w-full h-full p-2 focus:outline-none placeholder:text-slate-50 font-light text-xs bg-input-dark ' . // Убрал focus:border и focus:ring-indigo-500 отсюда
                               'rounded-sm ' .
                               'appearance-none border-0 ' .
                               'focus:ring-indigo-500 focus:border-indigo-500 ' .
                               ($hasIcon ? ' pl-7' : '')
                ]) }}
            ></textarea>
        @else
            <input
                id="{{ $id }}"
                type="{{ $type }}"
                {{ $attributes->except('class')->merge([
                    'class' => 'w-full p-2 focus:outline-none placeholder:text-slate-50 font-light text-xs bg-input-dark focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500' . ($hasIcon ? ' pl-7' : '')
                ]) }}
            >
        @endif
    </div>
</div>
