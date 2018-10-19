<?= form_open(current_url()) ?>
    <input type="hidden" name="alias" value="<?= $widgetAlias ?>">
    <div class="modal-header">
        <h4 class="modal-title" id="<?= $widgetAlias ?>-title">
            <?= e(lang('admin::lang.dashboard.text_edit_widget')) ?>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div
        class="modal-body"
    >
        <?php foreach ($widgetForm->getFields() as $field) { ?>
            <?= $widgetForm->renderField($field) ?>
        <?php } ?>
    </div>
    <div class="modal-footer">
        <button
            type="button"
            class="btn btn-primary"
            data-dismiss="modal"
            data-request="<?= $this->getEventHandler('onUpdateWidget') ?>"
        ><?= e(trans('admin::lang.text_save')) ?></button>
        <button
            type="button"
            class="btn btn-default"
            data-dismiss="modal"
        ><?= e(trans('admin::lang.button_close')) ?></button>
    </div>
<?= form_close() ?>