<?= form_open(current_url(),
    [
        'id' => 'edit-form',
        'role' => 'form',
        'method' => 'DELETE',
    ]
); ?>

<input type="hidden" name="_handler" value="onDelete">
<div class="toolbar">
    <div class="toolbar-action">
        <button
            type="submit"
            class="btn btn-danger"
            data-request="onDelete"
        ><?= lang('system::lang.extensions.button_yes_delete'); ?></button>
        <a class="btn btn-default" href="<?= admin_url('extensions'); ?>">
            <?= lang('system::lang.extensions.button_return_to_list'); ?>
        </a>
    </div>
</div>

<div class="form-fields">
    <?php $deleteAction = $extensionData
        ? lang('system::lang.extensions.text_files_data')
        : lang('system::lang.extensions.text_files'); ?>
    <p>
        <?= sprintf(lang('system::lang.extensions.alert_delete_warning'), $deleteAction, $extensionName); ?>
        <br/>
        <?= sprintf(lang('system::lang.extensions.alert_delete_confirm'), $deleteAction); ?>
    </p>
    <?php if ($extensionData) { ?>
        <div class="form-group span-full">
            <label for="input-delete-data"
                   class="control-label"
            ><?= lang('system::lang.extensions.label_delete_data'); ?></label>
            <div
                id="input-delete-data"
                class="btn-group btn-group-toggle"
                data-toggle="buttons"
            >
                <input
                    type="hidden"
                    name="delete_data"
                    value="0"
                >
                <div
                    class="field-switch"
                    data-control="switch"
                >
                    <input
                        type="checkbox"
                        name="delete_data"
                        id="delete-data"
                        class="field-switch-input"
                        value="1"
                    >
                    <label
                        class="field-switch-label"
                        for="delete-data"
                        style="width: 120px;"
                    >
                        <span class="field-switch-container">
                            <span class="field-switch-active">
                                <span class="field-switch-toggle bg-success"><?= lang('admin::lang.text_yes'); ?></span>
                            </span>
                            <span class="field-switch-inactive">
                                <span class="field-switch-toggle bg-danger"><?= lang('admin::lang.text_no'); ?></span>
                            </span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?= form_close(); ?>
