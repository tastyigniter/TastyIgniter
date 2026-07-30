<div>
    <ul class="nav navbar-nav">
        @foreach ($menuItems as $navItem)
            @continue(Auth::isLogged() && in_array($navItem->code, ['login', 'register']))
            @continue(!Auth::isLogged() && in_array($navItem->code, ['account', 'recent-orders']))
            <li
                @class(['nav-item', 'dropdown' => $navItem->items])
            >
                <a
                    id="navbar-{{ $navItem->code }}"
                    @class(['nav-link fw-medium', 'dropdown-toggle' => $navItem->items, 'active fw-bold text-primary' => $navItem->isActive || $navItem->isChildActive])
                    href="{{ $navItem->items ? '#' : $navItem->url }}"
                    @if ($navItem->items) data-bs-toggle="dropdown" @endif
                    {!! $navItem->extraAttributes !!}
                >@lang($navItem->title) @if ($navItem->items) <span class="caret"></span> @endif</a>
                @if ($navItem->items)
                    <div
                        class="dropdown-menu px-2"
                        aria-labelledby="navbar-{{ $navItem->code }}"
                        role="menu"
                    >
                        @foreach ($navItem->items as $item)
                            <a
                                @class(['dropdown-item py-2 rounded', 'active' => $item->isActive])
                                href="{{ $item->url }}"
                                {!! $item->extraAttributes !!}
                            >@lang($item->title)</a>
                        @endforeach
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</div>
