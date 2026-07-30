@props(['code', 'children' => []])
@php
    $isActive = (bool)AdminMenu::isActiveNavItem($code);
@endphp

<li {{ $attributes->class(['active' => $isActive]) }}>
    {{ $slot }}
</li>
