<div class="toolbar-search d-flex align-items-center pt-2 px-3 pb-4">
    <div id="marketplace-search" class="form-group search-group has-feedback flex-grow-1 shadow-sm">
        <input
            type="text"
            class="form-control search input-lg"
            placeholder="{{ sprintf(lang('system::lang.updates.text_search'), str_plural($itemType)) }}"
            data-search-type="{{ $itemType }}"
            data-search-action="{{ admin_url(str_plural($itemType).'/search') }}"
            data-search-ready="false"
        >
        <i class="form-control-feedback fa fa-search fa-icon"></i>
        <i class="form-control-feedback fa fa-spinner fa-icon loading" style="display: none"></i>
    </div>
</div>
