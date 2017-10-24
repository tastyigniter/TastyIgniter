<div class="panel panel-search">
    <div class="panel-body">
        <div id="marketplace-search" class="form-group search-group has-feedback">
            <input
                class="form-control search input-lg"
                placeholder="<?= sprintf(lang('system::updates.text_search'), $itemType); ?>" type="text"
                data-search-type="<?= $itemType; ?>" data-search-ready="false">
            <i class="form-control-feedback fa fa-search fa-icon"></i>
            <i class="form-control-feedback fa fa-spinner fa-icon loading" style="display: none"></i>
        </div>
    </div>
</div>
