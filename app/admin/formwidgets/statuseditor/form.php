<div
    id="<?= $this->getId('form-modal') ?>"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    data-status-editor>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= $formTitle ? e(lang($formTitle)) : '' ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            </div>
            <div class="modal-body">
                <?php foreach ($statusFormWidget->getFields() as $field): ?>
                    <?= $statusFormWidget->renderField($field) ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
