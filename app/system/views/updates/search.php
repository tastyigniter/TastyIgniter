<div class="panel panel-search">
    <div class="panel-body">
        <div id="marketplace-search" class="form-group search-group has-feedback">
            <input
                type="text"
                class="form-control search input-lg"
                placeholder="<?= sprintf(lang('system::lang.updates.text_search'), $itemType); ?>"
                data-search-type="<?= $itemType; ?>"
                data-search-action="<?= $searchActionUrl; ?>"
                data-search-ready="false"
            >
            <i class="form-control-feedback fa fa-search fa-icon"></i>
            <i class="form-control-feedback fa fa-spinner fa-icon loading" style="display: none"></i>
        </div>
    </div>
</div>
