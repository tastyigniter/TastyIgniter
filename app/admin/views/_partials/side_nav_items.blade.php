<ul {!! isset($navAttributes) ? Html::attributes($navAttributes) : '' !!}>
    @foreach($navItems as $code => $menu)
        @if(isset($menu['child']) && empty($menu['child']))
            @continue;
        @endif
        @php
            // Don't display items filtered by user permissions
            $hasChild = isset($menu['child']) && count($menu['child'])
        @endphp
        <li class="nav-item{{ ($isActive = $this->isActiveNavItem($code)) ? ' active' : '' }}">
            <a
                class="nav-link{{ isset($menu['class']) ? ' '.$menu['class'] : '' }}"
                href="{{ $menu['href'] ?: '#' }}"
                aria-expanded="{{ $isActive ? 'true' : 'false' }}"
            >
                @isset($menu['icon'])
                    <i class="fa {{ $menu['icon'] }} fa-fw"></i>
                @endisset

                @isset($menu['icon'], $menu['title'])
                    <span class="content">{{ $menu['title'] }}</span>
                @else
                    {{ $menu['title'] }}
                @endisset
            </a>

            @if($hasChild)
                {!! $this->makePartial('side_nav_items', [
                    'navItems'      => $menu['child'],
                    'navAttributes' => [
                        'class'         => 'nav collapse'.($isActive ? ' show' : ''),
                        'aria-expanded' => $isActive ? 'true' : 'false',
                    ],
                ]) !!}
            @endif
        </li>
    @endforeach
</ul>
