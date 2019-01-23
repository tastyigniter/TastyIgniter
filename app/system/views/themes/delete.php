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
        ><?= lang('system::lang.themes.button_yes_delete'); ?></button>
        <a class="btn btn-default" href="<?= admin_url('themes'); ?>">
            <?= lang('system::lang.themes.button_return_to_list'); ?>
        </a>
    </div>
</div>

<div class="form-fields flex-column">
    <?php $deleteAction = !empty($themeData)
        ? lang('system::lang.themes.text_files_data')
        : lang('system::lang.themes.text_files'); ?>
    <p><?= sprintf(lang('system::lang.themes.alert_delete_warning'), $deleteAction, $themeName); ?></p>
    <p><?= sprintf(lang('system::lang.themes.alert_delete_confirm'), $deleteAction); ?></p>
    <div id="deletedFiles" class="form-group">
        <textarea
            class="form-control"
            rows="10"
            readonly
        ><?= implode(PHP_EOL, $filesToDelete); ?></textarea>
    </div>

    <?php if ($themeData) { ?>
        <div class="form-group span-full">
            <label
                for="input-delete-data"
                class="control-label"
            ><?= lang('system::lang.themes.label_delete_data'); ?></label>
            <br>
            <div id="input-delete-data">
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
