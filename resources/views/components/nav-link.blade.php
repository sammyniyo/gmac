@props(['active'])

@php
$classes = ($active ?? false)
            ? 'admin-nav-link admin-nav-link--active'
            : 'admin-nav-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
