<div class="d-sm-flex">
    @if ($location->hasMedia('thumb'))
        <div class="w-sm-25 d-none d-sm-block me-sm-4">
            <img class="img-fluid" src="{{ $location->getThumb() }}" />
        </div>
    @endif

    <div class="">
        <dl class="no-spacing mb-0">
            <dd><h2 class="h4 mb-0 fw-normal">{{ $location->location_name }}</h2></dd>
            <dd>
                <span class="text-muted">{{ format_address($location->getAddress(), false) }}</span>
            </dd>
            <dd>{{ $location->location_telephone }}</dd>
            <dd>
                <a
                    href="{{ page_url('local.menus', ['location' => $location->permalink_slug]) }}"
                >@lang('igniter.orange::default.menu_menu')</a>
            </dd>
        </dl>
    </div>
</div>
