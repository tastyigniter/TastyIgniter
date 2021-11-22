@props(['navItems'])
@if(AdminAuth::isLogged())
    <aside {{ $attributes->merge(['class' => 'p-4 w-64 h-100 overflow-y-scroll overflow-y-lg-auto no-scrollbar'])}}>
        <div class="">
            {{ $slot }}
        </div>
        <div class="nav-sidebar">
            <x-nav
                id="side-nav-menu"
                class="nav flex-column"
            >
                @foreach($navItems as $code => $item)
                    @if(isset($item['child']) && empty($item['child']))
                        @continue;
                    @endif
                    <x-nav.item
                        :code="$code"
                        :children="$item['child'] ?? []"
                        class="nav-item"
                    >
                        <x-nav.item-link
                            class="nav-link {{ !empty($item['child']) ? 'has-arrow' : '' }} {{ $item['class'] ?? '' }}"
                            href="{{ $item['href'] ?? '#' }}"
                        >
                            <i class="fa {{ $item['icon'] }} fa-fw"></i>
                            <span class="mx-3">{{ $item['title'] }}</span>
                        </x-nav.item-link>
                    </x-nav.item>
                @endforeach
            </x-nav>
        </div>
    </aside>
@endif
