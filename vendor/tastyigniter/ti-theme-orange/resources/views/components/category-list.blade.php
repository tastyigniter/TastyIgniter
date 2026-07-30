<div class="layout-scrollable w-100">
    <ul id="navbar-categories" class="nav nav-pills nav-inline flex-nowrap py-3 w-100">
        <li class="nav-item">
            <a
                @class(['nav-link rounded py-1 text-nowrap', 'active' => !$selectedCategory])
                @if($useLinkAnchor)
                    href="#category-all-heading"
                @else
                    href="{{ page_url($menusPage, ['category' => null]) }}"
                    wire:navigate
                @endif
            >@lang('igniter.local::default.text_all_categories')</a>
        </li>

        @foreach ($categories->toFlatTree() as $category)
            @continue($hideEmpty && $category->menus_count < 1)

            <li class="nav-item">
                <a
                    @class(['nav-link rounded py-1', 'active' => ($selectedCategory && $category->permalink_slug == $selectedCategory->permalink_slug)])
                    @if($useLinkAnchor)
                        href="#category-{{ strtolower(str_slug($category->name)) }}-heading"
                    @else
                        href="{{ page_url($menusPage, ['category' => $category->permalink_slug]) }}"
                        wire:navigate
                    @endif
                >{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
