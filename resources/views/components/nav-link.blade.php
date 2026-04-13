@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex w-full items-center rounded-xl border border-teal-200 bg-teal-50 px-3 py-2.5 text-sm font-semibold leading-5 text-teal-900 shadow-sm transition duration-150 ease-in-out'
            : 'flex w-full items-center rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium leading-5 text-slate-600 hover:border-slate-200 hover:bg-white hover:text-slate-900 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
