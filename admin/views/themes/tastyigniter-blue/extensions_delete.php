<?php echo get_header(); ?>
<div class="row content">
    <div class="col-md-12">
        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p><?php echo sprintf(lang('alert_delete_warning'), $extension_title); ?></p>
                    <p><?php echo lang('alert_delete_confirm'); ?></p>
                    <div id="deletedFiles">
                        <textarea class="form-control" rows="10" readonly><?php echo implode(PHP_EOL, $files_to_delete); ?></textarea>
                    </div>
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