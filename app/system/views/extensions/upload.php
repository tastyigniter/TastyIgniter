<div class="row-fluid">
    <?= form_open(current_url(),
        [
            'id'      => 'preview-form',
            'role'    => 'form',
            'enctype' => 'multipart/form-data',
        ],
        ['_method' => 'PATCH']
    ); ?>

    <div class="toolbar">
        <div class="toolbar-action">
            <?= Template::getButtonList(); ?>
        </div>
    </div>

    <div class="panel panel-default text-center">
        <div class="panel-heading">
            <h4><?= lang('text_upload_title'); ?></h4>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="col-sm-6 center-block">
                    <div class="input-group">
                        <input type="text" class="form-control btn-file-input-value" disabled="disabled">
                        <span class="input-group-btn">
                                    <div class="btn btn-default btn-file-input">
                                        <i class="fa fa-fw fa-folder-open"></i>&nbsp;&nbsp;
                                        <span class="btn-file-input-choose"><?= lang('button_choose'); ?></span>
                                        <span class="btn-file-input-change hide"><?= lang('button_change'); ?></span>
                                        <input type="file"
                                               name="extension_zip"
                                               value="<?= set_value('extension_zip'); ?>"
                                               onchange="var file = this.files[0]
                                               $(this).closest('.btn-file-input-value').val(file.name)
                                               $(this).closest('.btn-file-input-change').removeClass('hide')
                                               $(this).closest('.btn-file-input-choose').addClass('hide') return false"
                                        />
                                    </div>
                                    <button type="submit" class="btn btn-primary" data-request="onUpload">
                                        <i class="fa fa-fw fa-upload">&nbsp;&nbsp;</i><?= lang('button_upload'); ?>
                                    </button>
                                </span>
                    </div>
                    <?= form_error('extension_zip', '<span class="text-danger">', '</span>'); ?>
                </div>
            </div>
        </div>
    </div>
    <?= form_close(); ?>
</div>
