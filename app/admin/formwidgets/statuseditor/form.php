<div
    id="<?= $this->getId('form-modal-content') ?>"
    class="modal-dialog"
    role="document"
>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?= $formTitle ? e(lang($formTitle)) : '' ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
        </div>
        <?= form_open(
            [
                'id' => 'status-editor-form',
                'role' => 'form',
                'method' => 'PATCH',
                'data-request' => $this->alias.'::onSaveRecord',
            ]
        ); ?>
        <div
            id="<?= $this->getId('form-modal-fields') ?>"
            class="modal-body progress-indicator-container"
        >
            <?= $this->makePartial('statuseditor/fields', ['formWidget' => $formWidget]) ?>
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