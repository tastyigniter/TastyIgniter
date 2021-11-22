@props(['code', 'children' => []])
@php
    $isActive = (bool)AdminMenu::isActiveNavItem($code);
@endphp

<li {{ $attributes->class(['active' => $isActive]) }}>
    {{ $slot }}

    @if($children)
        <x-nav
            class="nav collapse {{ $isActive ? ' show' : '' }}"
            aria-expanded="{{ $isActive ? 'true' : 'false' }}"
        >
            @foreach($children as $childCode => $childItem)
                @if(isset($childItem['child']) && empty($childItem['child']))
                    @continue;
                @endif
                <x-nav.item
                    :code="$childCode"
                    class="nav-item w-100"
                >
                    <x-nav.item-link
                        class="nav-link {{ $childItem['class'] ?? '' }}"
                        href="{{ $childItem['href'] ?? '#' }}"
                    >
                        <span>{{ $childItem['title'] }}</span>
                    </x-nav.item-link>
                </x-nav.item>
            @endforeach
        </x-nav>
    @endif
</li>
