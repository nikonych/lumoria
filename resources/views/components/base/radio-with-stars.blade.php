@props([
    'value' => '',
    'label' => '',
    'stars' => 0,
])

@php
    $wireModel = null;
    foreach ($attributes->getAttributes() as $key => $attr) {
        if (str_starts_with($key, 'wire:model')) {
            $wireModel = $attr;
            break;
        }
    }

    $checked = false;
    if ($wireModel && isset($this->{$wireModel})) {
        $checked = $this->{$wireModel} == $value;
    }
@endphp

<label for="{{ $attributes->get('id') }}" class="inline-flex items-center cursor-pointer group">
    <input {{ $attributes->merge(['class' => 'sr-only peer']) }}
           type="radio"
           value="{{ $value }}"
           @if($checked) checked @endif>

    <div class="relative flex items-center justify-center w-4 h-4 bg-transparent border border-indigo-700 rounded-xs group-hover:border-indigo-600 transition-colors">
        <div class="absolute w-2.5 h-2.5 bg-indigo-700 transition-opacity {{ $checked ? 'opacity-100' : 'opacity-0' }}"></div>
    </div>

    <span class="ml-2 flex items-center">
        @for($i = 1; $i <= 5; $i++)
            <svg class="w-4 h-4 {{ $i <= $stars ? 'text-indigo-500' : 'text-gray-600' }}"
                 fill="currentColor"
                 viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @endfor

        @if($label !== '' && $label !== null)
            <span class="ml-2 text-slate-200">{{ $label }}</span>
        @endif
    </span>
</label>
