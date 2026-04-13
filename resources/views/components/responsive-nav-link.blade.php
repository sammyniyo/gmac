@props(['active'])

@php
$classes = ($active ?? false)
            ? 'admin-nav-link admin-nav-link--active admin-nav-link--mobile'
            : 'admin-nav-link admin-nav-link--mobile';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
