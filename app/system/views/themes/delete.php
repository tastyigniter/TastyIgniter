<div class="row content">
    <div class="col-md-12">
        <?= form_open(current_url(),
            [
                'id'   => 'edit-form',
                'role' => 'form',
            ],
            ['_method' => 'DELETE']
        ); ?>

        <?= $this->renderForm(); ?>

        <?= form_close(); ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $delete_action = !empty($theme_data) ? lang('system::themes.text_files_data') : lang('system::themes.text_files'); ?>
                <p><?= sprintf(lang('system::themes.alert_delete_warning'), $delete_action, $theme_name); ?></p>
                <div id="deletedFiles">
                        <textarea
                            class="form-control"
                            rows="10"
                            readonly
                        ><?= implode(PHP_EOL, $files_to_delete); ?></textarea>
                </div>
                <p class="wrap-top"><?= sprintf(lang('system::themes.alert_delete_confirm'), $delete_action); ?></p>
                <?php if ($theme_data) { ?>
                    <div class="form-group wrap-top">
                        <label for="input-delete-data" class="col-sm-2 control-label">
                            <?= lang('system::themes.label_delete_data'); ?>
                        </label>
                        <div class="col-sm-5">
                            <div
                                id="input-delete-data"
                                class="btn-group btn-group-switch"
                                data-toggle="buttons"
                            >
                                <label class="btn btn-default">
                                    <input
                                        type="radio"
                                        name="delete_data"
                                        value="0" <?= set_radio('delete_data', '0'); ?>
                                    ><?= lang('admin::default.text_no'); ?>
                                </label>
                                <label class="btn btn-default active">
                                    <input
                                        type="radio"
                                        name="delete_data"
                                        value="1" <?= set_radio('delete_data', '1', TRUE); ?>
                                    ><?= lang('admin::default.text_yes'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="panel-footer">
                <input type="hidden" name="confirm_delete" value="<?= $theme_code; ?>">
                <a class="btn btn-default"
                   href="<?= admin_url('themes'); ?>"
                ><?= lang('system::themes.button_return_to_list'); ?></a>
                <button type="submit" class="btn btn-danger"><?= lang('system::themes.button_yes_delete'); ?></button>
                <button
                    type="button"
                    class="btn btn-default"
                    onclick="$('#deletedFiles').slideToggle()"
                ><?= lang('system::themes.text_view_files'); ?></button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
