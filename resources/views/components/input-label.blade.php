@props([
    'value',
    'optional' => false
])

@if ($optional)
    <label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
        <span class="pr-2">{{ $value }}</span>
        <span>{{ __('global.optional') }}</span>
    </label>
@else
    <label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
        {{ $value ?? $slot }}
    </label>
@endif
