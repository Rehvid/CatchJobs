@props([
    'status'
])

@if ($status == 0)
<span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
    {{ __('global.status.pending') }}
</span>
@endif

@if ($status == 1)
<span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
    {{ __('global.status.reject') }}
</span>
@endif

@if ($status == 2)
<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
    {{ __('global.status.accept') }}
</span>
@endif
