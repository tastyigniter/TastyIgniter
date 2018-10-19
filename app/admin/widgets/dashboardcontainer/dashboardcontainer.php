<div
    data-control="dashboard-container"
    data-alias="<?= $this->alias ?>"
>
    <?php if ($this->canAddAndDelete) { ?>
        <div id="<?= $this->getId('container-toolbar') ?>" class="toolbar btn-toolbar" data-container-toolbar>
            <?= $this->makePartial('widget_toolbar') ?>
        </div>
    <?php } ?>

    <div id="<?= $this->getId('container') ?>">
        <div class="loading">
            <span class="spinner"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>
        </div>
    </div>
</div>
