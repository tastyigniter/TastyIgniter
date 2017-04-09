<?php echo get_header(); ?>
<div class="row content">
    <div class="col-md-12">
        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>" enctype="multipart/form-data">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <h4><?php echo lang('text_upload_title'); ?></h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-6 center-block">
                            <div class="input-group">
                                <input type="text" class="form-control btn-file-input-value" disabled="disabled">
                                <span class="input-group-btn">
                                    <div class="btn btn-default btn-file-input">
                                        <i class="fa fa-fw fa-folder-open"></i>&nbsp;&nbsp;
                                        <span class="btn-file-input-choose"><?php echo lang('button_choose'); ?></span>
                                        <span class="btn-file-input-change hide"><?php echo lang('button_change'); ?></span>
                                        <input type="file" name="extension_zip" value="<?php echo set_value('extension_zip'); ?>" onchange="var file = this.files[0];$('.btn-file-input-value').val(file.name);$('.btn-file-input-change').removeClass('hide');$('.btn-file-input-browse').addClass('hide');" />
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-fw fa-upload">&nbsp;&nbsp;</i><?php echo lang('button_upload'); ?>
                                    </button>
                                </span>
                            </div>
                            <?php echo form_error('extension_zip', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                </div>
            </div>
         </form>
    </div>
</div>
<?php echo get_footer(); ?>