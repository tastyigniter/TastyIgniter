<div
    data-control="components"
    data-alias="<?= $this->alias ?>"
    data-add-handler="<?= $onAddEventHandler ?>"
    data-sortable-container=".components-container"
>

    <div class="components">
        <div class="components-container">
            <div class="components-item components-picker">
                <div
                    class="component btn btn-light"
                    data-control="toggle-components"
                    data-toggle="modal"
                    data-target="#<?= $this->getId('components-modal') ?>"
                >
                    <b><i class="fa fa-plus"></i></b>
                    <p class="text-muted mb-0"><?= lang($this->prompt) ?></p>
                </div>
            </div>
            <?php if (count($components)) { ?>
                <?php foreach ($components as $code => $component) { ?>
                    <?= $this->makePartial('component', [
                        'component' => $component,
                        'field' => $field,
                    ]) ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <div
        id="<?= $this->getId('components-modal') ?>"
        class="modal show"
        data-control="components-modal"
        role="dialog"
        tabindex="-1"
        aria-label="#<?= $this->getId('components-modal') ?>"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <?= $this->makePartial('list') ?>
            </div>
        </div>
    </div>
</div>
