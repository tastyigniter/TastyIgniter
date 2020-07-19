<div
    class="modal slideInDown fade"
    id="newWidgetModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="newWidgetModalTitle"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div id="<?= $this->getId('new-widget-modal-content') ?>" class="modal-content">
            <div class="modal-body">
                <div class="progress-indicator">
                    <span class="spinner"><span class="ti-loading fa-3x fa-fw"></span></span>
                    <?= e(lang('admin::lang.text_loading')) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="toolbar-action pt-3 px-0">
    <?php if ($this->canManage) { ?>
        <button
            type="button"
            class="btn btn-outline-primary"
            data-toggle="modal"
            data-target="#newWidgetModal"
            data-request="<?= $this->getEventHandler('onLoadAddPopup') ?>"
            title="<?= e(lang('admin::lang.dashboard.button_add_widget')) ?>"
            tabindex="-1"
        ><i class="fa fa-plus"></i></button>
        <button
            type="button"
            class="btn btn-outline-danger"
            data-request="<?= $this->getEventHandler('onResetWidgets') ?>"
            data-request-confirm="<?= e(trans('admin::lang.alert_warning_confirm')) ?>"
            data-attach-loading
            title="<?= e(lang('admin::lang.dashboard.button_reset_widgets')) ?>"
            tabindex="-1"
        ><i class="fa fa-refresh"></i></button>
    <?php } ?>
    <?php if ($this->canSetDefault) { ?>
        <button
            type="button"
            class="btn btn-outline-default"
            data-request="<?= $this->getEventHandler('onSetAsDefault') ?>"
            data-request-confirm="<?= e(trans('admin::lang.dashboard.alert_set_default_confirm')) ?>"
            data-attach-loading
            title="<?= e(trans('admin::lang.dashboard.button_set_default')) ?>"
            tabindex="-1"
        ><i class="fa fa-save"></i></button>
    <?php } ?>
</div>
