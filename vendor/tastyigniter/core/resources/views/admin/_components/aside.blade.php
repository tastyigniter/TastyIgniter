@props(['navItems'])
@if(AdminAuth::isLogged())
    <div {{ $attributes->merge(['id' => 'navSidebar', 'class' => 'nav-sidebar w-100', 'role' => 'navigation'])}}>
        <x-igniter.admin::nav
            id="side-nav-menu"
            class="nav flex-column"
        >
            @foreach($navItems as $code => $item)
                @if(isset($item['child']) && empty($item['child']))
                    @continue;
                @endif
                @php($isActive = (bool)AdminMenu::isActiveNavItem($code))
                <x-igniter.admin::nav.item
                    :code="$code"
                    class="nav-item"
                >
                    <x-igniter.admin::nav.item-link
                        :hasChildTarget="!empty($item['child']) ? '#'.$code.'-'.$loop->index : ''"
                        class="nav-link mb-1 {{ !empty($item['child']) ? 'has-arrow' : '' }} {{ $item['class'] ?? '' }}"
                        href="{{ $item['href'] ?? '#' }}"
                        target="{{ $item['target'] ?? '_self' }}"
                        aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                    >
                        <i class="fa {{ $item['icon'] }} fa-fw"></i><span>{{ $item['title'] }}</span>
                    </x-igniter.admin::nav.item-link>

                    @if($children = array_get($item, 'child', []))
                        <x-igniter.admin::nav
                            id="{{ $code }}-{{ $loop->index }}"
                            class="nav collapse {{ $isActive ? ' show' : '' }}"
                            data-bs-parent="#side-nav-menu"
                        >
                            @foreach($children as $childCode => $childItem)
                                @if(isset($childItem['child']) && empty($childItem['child']))
                                    @continue;
                                @endif
                                <x-igniter.admin::nav.item
                                    :code="$childCode"
                                    class="nav-item w-100"
                                >
                                    <x-igniter.admin::nav.item-link
                                        class="nav-link mb-1 {{ $childItem['class'] ?? '' }}"
                                        href="{{ $childItem['href'] ?? '#' }}"
                                        target="{{ $childItem['target'] ?? '_self' }}"
                                    >
                                        <span>{{ $childItem['title'] }}</span>
                                    </x-igniter.admin::nav.item-link>
                                </x-igniter.admin::nav.item>
                            @endforeach
                        </x-igniter.admin::nav>
                    @endif
                </x-igniter.admin::nav.item>
            @endforeach
        </x-igniter.admin::nav>
    </div>
@endif
