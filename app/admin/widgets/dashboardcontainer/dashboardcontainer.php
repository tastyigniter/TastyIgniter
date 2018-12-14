<div
    data-control="dashboard-container"
    data-alias="<?= $this->alias ?>"
>
    <div id="<?= $this->getId('container') ?>" class="dashboard-widgets">
        <div class="loading">
            <span class="spinner"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>
        </div>
    </div>

    <?php if ($this->canAddAndDelete) { ?>
        <div id="<?= $this->getId('container-toolbar') ?>" class="toolbar dashboard-toolbar btn-toolbar"
             data-container-toolbar>
            <?= $this->makePartial('widget_toolbar') ?>
        </div>
    <?php } ?>
</div>
