<div class="panel panel-search">
    <div class="panel-body">
        <div class="d-flex flex-column flex-lg-row align-items-center">
            <div id="marketplace-search" class="form-group search-group has-feedback flex-grow-1">
                <input
                    type="text"
                    class="form-control search input-lg"
                    placeholder="{{ sprintf(lang('system::lang.updates.text_search'), str_plural($itemType)) }}"
                    data-search-type="{{ $itemType }}"
                    data-search-action="{{ $searchActionUrl }}"
                    data-search-ready="false"
                >
                <i class="form-control-feedback fa fa-search fa-icon"></i>
                <i class="form-control-feedback fa fa-spinner fa-icon loading" style="display: none"></i>
            </div>
            <div class="ml-lg-4">
                <a
                    class="btn btn-secondary"
                    href="https://tastyigniter.com/marketplace"
                    target="_blank"
                ><b>@lang('system::lang.updates.button_marketplace')</b></a>
            </div>
        </div>
    </div>
</div>
