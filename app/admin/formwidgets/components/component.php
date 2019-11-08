<div
    class="components-item"
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
            data-prompt="<?= lang('admin::lang.alert_confirm') ?>"
        ><i class="fa fa-times text-danger"></i></a>
    </div>
    <div
        class="component btn btn-light text-left"
        data-control="component"
        data-toggle="modal"
        data-target="#<?= $this->getId('components-item-modal-'.$component->alias) ?>"
    >
        <b><?= e(lang($component->name)) ?></b>
        <p class="text-muted mb-0"><?= $component->description ? e(lang($component->description)) : '' ?></p>
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
                    <div class="components-item-form">
                        <?php foreach ($component->widget->getFields() as $componentField) { ?>
                            <?= $component->widget->renderField($componentField) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
