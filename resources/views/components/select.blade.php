@props([
    'name' => '',
    'id' => '',
])

<select
    id="{{ $id }}"
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full']) }}
    name="{{ $name }}"
>
    {{ $slot }}
</select>

