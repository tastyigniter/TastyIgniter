<?php echo get_header(); ?>
<div class="row content">
    <div class="col-md-12">
        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p><?php echo sprintf(lang('alert_copy_warning'), $copy_action, $theme_title); ?></p>
                    <p><?php echo sprintf(lang('alert_copy_confirm'), $copy_action); ?></p>
                    <div id="copyFiles">
                        <textarea class="form-control" rows="5" readonly><?php echo implode(PHP_EOL, $files_to_copy); ?></textarea>
                    </div>
                    <?php if ($theme_data) { ?>
                        <div class="form-group wrap-top">
                            <label for="input-copy-data" class="col-sm-2 control-label"><?php echo lang('label_copy_data'); ?></label>
                            <div class="col-sm-5">
                                <div id="input-copy-data" class="btn-group btn-group-switch" data-toggle="buttons">
                                    <label class="btn btn-default"><input type="radio" name="copy_data" value="0" <?php echo set_radio('copy_data', '0'); ?>><?php echo lang('text_no'); ?></label>
                                    <label class="btn btn-default active"><input type="radio" name="copy_data" value="1" <?php echo set_radio('copy_data', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="panel-footer">
                    <input type="hidden" name="confirm_copy" value="<?php echo $theme_name; ?>">
                    <a class="btn btn-default" href="<?php echo site_url('themes'); ?>"><?php echo lang('button_return_to_list'); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo lang('button_yes_copy'); ?></button>
                    <button type="button" class="btn btn-default" onclick="$('#copyFiles').slideToggle();"><?php echo lang('text_view_files'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php echo get_footer(); ?>