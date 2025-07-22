@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-3 py-2 text-sm font-medium rounded-md text-white bg-karyasuci-primary dark:bg-karyasuci-primary' // Style untuk link aktif
            : 'flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'; // Style untuk link tidak aktif
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>