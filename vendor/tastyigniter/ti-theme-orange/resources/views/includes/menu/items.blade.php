<div class="menu-items row g-3">
    @forelse ($menuItems as $menuItemData)
        <div wire:key="{{ $menuItemData->id }}" class="col-lg-6">
            @include('igniter-orange::includes.menu.item')
        </div>
    @empty
        <p>@lang('igniter.local::default.text_empty_menus')</p>
    @endforelse
</div>
