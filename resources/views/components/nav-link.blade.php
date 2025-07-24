@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white bg-gray-100 hover:bg-gray-400 dar:bg-gray-400 dark:hover:bg-gray-400 group'
            : 'flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
