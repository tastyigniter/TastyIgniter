<div
    class="page-x-spacer"
    data-control="dashboard-container"
    data-alias="<?= $this->alias ?>"
    data-sortable-container="#<?= $this->getId('container-list') ?>"
>
    <div id="<?= $this->getId('container') ?>" class="dashboard-widgets">
        <div class="progress-indicator">
            <span class="spinner"><span class="ti-loading fa-3x fa-fw"></span></span>
            <?= e(lang('admin::lang.text_loading')) ?>
        </div>
    </div>

    <div
        id="<?= $this->getId('container-toolbar') ?>" class="toolbar dashboard-toolbar btn-toolbar"
        data-container-toolbar>
        <?= $this->makePartial('widget_toolbar') ?>
    </div>
</div>
