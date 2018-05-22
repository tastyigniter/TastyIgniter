<div
    class="components-item mr-2"
>
    <div class="components-item-action">
        <a
            data-control="drag-component"
            class="handle btn btn-light btn-sm"
            role="button"
        ><i class="fa fa-bars"></i></a>
        <a
            data-control="remove-component"
            class="remove btn btn-light btn-sm pull-right"
            role="button"
        ><i class="fa fa-times text-danger"></i></a>
    </div>
    <div
        class="component btn btn-light text-left"
        data-control="component"
        data-toggle="modal"
        data-target="#<?= $this->getId('components-item-modal-'.$component->alias) ?>"
    >
        <h5>
            <?= e(lang($component->name)) ?>
        </h5>
        <h6 class="text-muted"><?= $component->description ? e(lang($component->description)) : '' ?></h6>
    </div>
    <input
        type="hidden"
        name="<?= $field->getName() ?>[<?= $component->alias ?>]"
        value="<?= $component->code ?>"
    >

    <div
        id="<?= $this->getId('components-item-modal-'.$component->alias) ?>"
        class="modal show"
        role="dialog"
        tabindex="-1"
        aria-label="#<?= $this->getId('components-item-modal-'.$component->alias) ?>"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?= e(lang($component->name)) ?></h4>
                </div>
                <div class="modal-body">
                    <?php foreach ($component->widget->getFields() as $componentField) { ?>
                        <?= $component->widget->renderField($componentField) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
