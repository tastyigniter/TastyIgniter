<div class="row-fluid">
    <?= form_open(current_url(),
        [
            'id'   => 'edit-form',
            'role' => 'form',
                'method' => 'PATCH'
        ]
    ); ?>

    <input type="hidden" name="_handler" value="onCreateChild">

    <div class="toolbar">
        <div class="toolbar-action">
            <button type="submit" class="btn btn-primary"><?= lang('system::themes.button_yes_copy'); ?></button>
            <a class="btn btn-default"
               href="<?= admin_url('themes'); ?>"><?= lang('system::themes.button_return_to_list'); ?></a>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php $copyAction = $themeData ? lang('system::themes.text_files_data') : lang('system::themes.text_files'); ?>
            <p><?= sprintf(lang('system::themes.alert_copy_warning'), $copyAction, $themeName); ?></p>
            <p><?= sprintf(lang('system::themes.alert_copy_confirm'), $copyAction); ?></p>
            <div id="copyFiles">
                        <textarea class="form-control"
                                  rows="5"
                                  readonly><?= implode(PHP_EOL, $filesToCopy); ?></textarea>
            </div>
            <?php if ($themeData) { ?>
                <div class="form-group wrap-top">
                    <label for="input-copy-data"
                           class="col-sm-2 control-label"><?= lang('system::themes.label_copy_data'); ?></label>
                    <div class="col-sm-5">
                        <input
                            type="checkbox"
                            id="input-copy-data"
                            name="copy_data"
                            data-toggle="toggle"
                            data-onstyle="success" data-offstyle="danger"
                            data-on="<?= e(lang('admin::default.text_yes')) ?>"
                            data-off="<?= e(lang('system::themes.label_copy_data')) ?>"
                            value="1">
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?= form_close(); ?>
</div>
