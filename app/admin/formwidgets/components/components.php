<div
    data-control="components"
    data-alias="<?= $this->alias ?>"
    data-add-handler="<?= $onAddEventHandler ?>"
    data-sortable-container=".components-container"
>

    <div class="components">
        <div class="components-container d-flex align-content-stretch">
            <div class="components-item mr-2 components-picker">
                <div
                    class="component btn btn-light"
                    data-control="toggle-components"
                    data-toggle="modal"
                    data-target="#<?= $this->getId('components-modal') ?>"
                >
                    <h5><i class="fa fa-plus"></i></h5>
                    <h6 class="text-muted"><?= lang($this->prompt) ?></h6>
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
