<div
    class="widget-container"
>
    <div
        id="<?= $this->getId('container-list') ?>"
        class="widget-list row <?= $this->canManage ? 'add-delete' : null ?>"
        data-container-widget
    >
        <?= $this->makePartial('widget_list') ?>
    </div>
</div>
