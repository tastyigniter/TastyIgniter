<?php echo get_header(); ?>
<div class="row content">
    <div class="col-md-12">
        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p><?php echo sprintf(lang('alert_delete_warning'), $delete_action, $extension_title); ?></p>
                    <p><?php echo sprintf(lang('alert_delete_confirm'), $delete_action); ?></p>
                    <div id="deletedFiles">
                        <textarea class="form-control" rows="10" readonly><?php echo implode(PHP_EOL, $files_to_delete); ?></textarea>
                    </div>
                    <?php if ($extension_data) { ?>
                        <div class="form-group wrap-top">
                            <label for="input-delete-data" class="col-sm-2 control-label"><?php echo lang('label_delete_data'); ?></label>
                            <div class="col-sm-5">
                                <div id="input-delete-data" class="btn-group btn-group-switch" data-toggle="buttons">
                                    <label class="btn btn-default"><input type="radio" name="delete_data" value="0" <?php echo set_radio('delete_data', '0'); ?>><?php echo lang('text_no'); ?></label>
                                    <label class="btn btn-default active"><input type="radio" name="delete_data" value="1" <?php echo set_radio('delete_data', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="panel-footer">
                    <input type="hidden" name="confirm_delete" value="<?php echo $extension_name; ?>">
                    <a class="btn btn-default" href="<?php echo site_url('extensions?filter_type='.$extension_type); ?>"><?php echo lang('button_return_to_list'); ?></a>
                    <button type="submit" class="btn btn-danger"><?php echo lang('button_yes_delete'); ?></button>
                    <button type="button" class="btn btn-default" onclick="$('#deletedFiles').slideToggle();"><?php echo lang('text_view_files'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php echo get_footer(); ?>