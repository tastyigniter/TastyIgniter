<div
    class="btn-toolbar justify-content-between"
    data-control="map-toolbar"
    role="toolbar"
>
    <div class="toolbar-item">
        <div class="btn-group btn-group-sm">
            <button
                type="button"
                class="btn btn-light"
                data-control="add-area"
                data-handler="<?= $this->getEventHandler('onAddArea') ?>"
            ><i class="fa fa-plus"></i>&nbsp;&nbsp;<?= $prompt ? e(lang($prompt)) : '' ?></button>
        </div>
    </div>

    <div class="toolbar-item">
        <div class="btn-group btn-group-sm">
            <button
                type="button"
                class="btn btn-light active"
                data-toggle="button"
                data-control="toggle-editor"
            ><i class="fa fa-bars"></i></button>
            <button
                type="button"
                class="btn btn-light text-danger"
                title="Remove"
                data-confirm="<?= lang('admin::lang.alert_warning_confirm'); ?>"
                data-control="remove-area"
            ><i class="fa fa-trash-alt"></i></button>
        </div>
    </div>
</div>
