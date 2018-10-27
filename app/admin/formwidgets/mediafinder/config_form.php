<div class="modal-content">
    <div class="modal-header">
        <span class="modal-title"><?= lang('main::lang.media_manager.help_attachment_config'); ?></span>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <?= form_open([
        'id' => 'attachment-config-form',
        'role' => 'form',
        'method' => 'POST',
        'data-request' => $this->alias.'::onSaveAttachmentConfig',
    ]); ?>
    <input type="hidden" name="media_id" value="<?= $formMediaId ?>">
    <div class="modal-body">
        <div class="form-fields p-0">
            <?php foreach ($formWidget->getFields() as $field) { ?>
                <?= $formWidget->renderField($field) ?>
            <?php } ?>
        </div>
    </div>
    <div class="modal-footer text-right">
        <a
            class="btn-link mr-auto"
            href="<?= $formWidget->model->getPath() ?>"
            target="_blank"
        ><i class="fa fa-link"></i></a>
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
