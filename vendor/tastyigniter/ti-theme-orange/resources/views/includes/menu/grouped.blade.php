<div
    class="menu-group"
    data-bs-spy="scroll"
    data-bs-target="#navbar-categories"
    data-bs-root-margin="80px 0px -80%"
    data-bs-threshold="[1]"
    data-bs-smooth-scroll="true"
>
    @forelse ($groupedMenuItems as $categoryId => $menuList)
        <div @class(['menu-group-item'])>
            @if ($categoryId > 0)
                @php
                    $menuCategory = array_get($menuListCategories, $categoryId);
                    $menuCategoryAlias = strtolower(str_slug($menuCategory->name));
                @endphp
                <div id="category-{{ $menuCategoryAlias }}-heading" class="category-header" role="tab">
                    <h4
                        @class(['menu-group-toggle pt-3 pb-2 mb-0', 'collapsed' => $loop->iteration >= $collapseCategoriesAfter])
                        data-bs-toggle="collapse"
                        data-bs-target="#category-{{ $menuCategoryAlias }}-collapse"
                        aria-expanded="false"
                        aria-controls="category-{{ $menuCategoryAlias }}-heading"
                    >{{ $menuCategory->name }}</h4>
                </div>
                <div
                    id="category-{{ $menuCategoryAlias }}-collapse"
                    class="category-items collapse {{ $loop->iteration < $collapseCategoriesAfter ? 'show' : '' }}"
                    role="tabpanel" aria-labelledby="{{ $menuCategoryAlias }}"
                >
                    <div class="menu-category">
                        @if (strlen($menuCategory->description))
                            <p>{!! nl2br($menuCategory->description) !!}</p>
                        @endif

                        @if ($showThumb && $menuCategory->hasMedia('thumb'))
                            <div class="image mb-3">
                                <img
                                    class="img-fluid rounded"
                                    src="{{ $menuCategory->getThumb(['width' => $categoryThumbWidth, 'height' => $categoryThumbHeight]) }}"
                                    alt="{{ $menuCategory->name }}"
                                />
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        @include('igniter-orange::includes.menu.items', ['menuItems' => $menuList])
                    </div>
                </div>
            @else
                <div id="category-all-heading" class="mb-3">
                    @include('igniter-orange::includes.menu.items', ['menuItems' => $menuList])
                </div>
            @endif
        </div>
    @empty
        <div class="menu-group-item">
            <p>@lang('igniter.local::default.text_no_category')</p>
        </div>
    @endforelse
</div>
