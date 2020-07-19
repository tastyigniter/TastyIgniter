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
    <p><?= sprintf(lang('system::lang.themes.alert_delete_warning'), $deleteAction, $themeObj->label); ?></p>
    <p><?= sprintf(lang('system::lang.themes.alert_delete_confirm'), $deleteAction); ?></p>

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
                <div class="custom-control custom-switch">
                    <input
                        type="checkbox"
                        name="delete_data"
                        id="delete-data"
                        class="custom-control-input"
                        value="1"
                    />
                    <label
                        class="custom-control-label"
                        for="delete-data"
                    ><?= e(lang('admin::lang.text_no')) ?>/<?= e(lang('admin::lang.text_yes')) ?></label>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?= form_close(); ?>
