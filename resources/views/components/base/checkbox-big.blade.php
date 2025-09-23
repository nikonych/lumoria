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
    if ($wireModel) {
        $parts = explode('.', $wireModel);
        $value_to_check = $this;

        foreach ($parts as $part) {
            if (isset($value_to_check->{$part})) {
                $value_to_check = $value_to_check->{$part};
            } else {
                $value_to_check = null;
                break;
            }
        }

        if (is_array($value_to_check)) {
            $checked = in_array($value, $value_to_check);
        }
    }
@endphp

<label for="{{ $attributes->get('id') }}" class="inline-flex items-center cursor-pointer group">
    <input {{ $attributes->merge(['class' => 'sr-only peer']) }}
           type="checkbox"
           value="{{ $value }}"
           @if($checked) checked @endif>

    <div class="relative flex items-center justify-center w-6 h-6 bg-black border border-indigo-700 rounded-xs group-hover:border-indigo-600 transition-colors">
        <div class="absolute w-4 h-4 bg-indigo-700 transition-opacity {{ $checked ? 'opacity-100' : 'opacity-0' }}"></div>
    </div>

    @if($label !== '' && $label !== null)
        <span class="ml-2 text-slate-200">{{ $label }}</span>
    @endif
</label>
