<div class="modal-dialog <?= $this->popupSize ?>">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?= e(lang($formTitle)) ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div id="modal-notification"></div>
        <?= form_open(
            [
                'id' => 'record-editor-form',
                'role' => 'form',
                'method' => $formWidget->context == 'create' ? 'POST' : 'PATCH',
                'data-request' => $this->alias.'::onSaveRecord',
            ]
        ); ?>
        <input type="hidden" name="recordId" value="<?= $formRecordId ?>">
        <div class="modal-body">
            <div class="form-fields p-0">
                <?php foreach ($formWidget->getFields() as $field): ?>
                    <?= $formWidget->renderField($field) ?>
                <?php endforeach ?>
            </div>
        </div>
        <div class="modal-footer text-right">
            <button
                type="button"
                class="btn btn-link"
                data-dismiss="modal"
            ><?= lang('admin::lang.button_close') ?></button>
            <button
                type="submit"
                class="btn btn-primary"
            ><?= lang('admin::lang.button_save') ?></button>
        </div>
        <?= form_close(); ?>
    </div>
</div>
