@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl border border-teal-200 bg-teal-50 px-4 py-3 text-start text-base font-semibold text-teal-900 shadow-sm transition duration-150 ease-in-out'
            : 'block w-full rounded-xl border border-transparent px-4 py-3 text-start text-base font-medium text-slate-600 hover:border-slate-200 hover:bg-white hover:text-slate-900 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
