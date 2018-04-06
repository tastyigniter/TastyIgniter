<div class="row content">
    <div class="col-md-12">
        <?= form_open(current_url(),
            [
                'id'      => 'upload-form',
                'role'    => 'form',
                'enctype' => 'multipart/form-data',
                'method'  => 'PATCH',
            ]
        ); ?>

        <div class="toolbar">
            <div class="toolbar-action">
                <?= Template::getButtonList(); ?>
            </div>
        </div>

        <div class="panel panel-default text-center">
            <div class="panel-heading">
                <h4><?= lang('system::themes.text_upload_title'); ?></h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-6 center-block">
                        <div class="input-group">
                            <input type="text" class="form-control btn-file-input-value" disabled="disabled">
                            <span class="input-group-btn">
                                    <div class="btn btn-default btn-file-input">
                                        <i class="fa fa-fw fa-folder-open"></i>&nbsp;&nbsp;
                                        <span class="btn-file-input-browse"><?= lang('system::themes.button_choose'); ?></span>
                                        <span class="btn-file-input-change hide"><?= lang('system::themes.button_change'); ?></span>
                                        <input type="file"
                                               name="theme_zip"
                                               value="<?= set_value('theme_zip'); ?>"
                                               onchange="var file = this.files[0]
                                               $('.btn-file-input-value').val(file.name)
                                               $('.btn-file-input-change').removeClass('hide')
                                               $('.btn-file-input-browse').addClass('hide')"
                                        />
                                    </div>
                                    <button type="submit" class="btn btn-primary" data-request="onUpload">
                                        <i class="fa fa-fw fa-upload">&nbsp;&nbsp;</i><?= lang('system::themes.button_upload'); ?>
                                    </button>
                                </span>
                        </div>
                        <?= form_error('theme_zip', '<span class="text-danger">', '</span>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
