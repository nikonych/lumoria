@props([
    'value' => '',
    'label' => '',
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
    if ($wireModel && isset($this->{$wireModel}) && is_array($this->{$wireModel})) {
        $checked = in_array($value, $this->{$wireModel});
    }
@endphp

<label for="{{ $attributes->get('id') }}" class="inline-flex items-center cursor-pointer group">
    <input {{ $attributes->merge(['class' => 'sr-only peer']) }}
           type="checkbox"
           value="{{ $value }}"
           @if($checked) checked @endif>

    <div class="relative flex items-center justify-center w-4 h-4 bg-transparent border border-indigo-700 rounded-xs group-hover:border-indigo-600 transition-colors">
        <div class="absolute w-2.5 h-2.5 bg-indigo-700 transition-opacity {{ $checked ? 'opacity-100' : 'opacity-0' }}"></div>
    </div>

    @if($label !== '' && $label !== null)
        <span class="ml-2 text-slate-200">{{ $label }}</span>
    @endif
</label>
