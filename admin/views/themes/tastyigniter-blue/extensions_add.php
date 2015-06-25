<?php echo get_header(); ?>
<div class="row content">
    <div class="col-md-12">
        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>" enctype="multipart/form-data">
            <div class="table-responsive">
                <table class="table table-striped table-border">
                    <thead>
                    <tr>
                        <th><?php echo lang('alert_info_upload'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="file" name="extension_zip" value="<?php echo set_value('extension_zip'); ?>" id="" />
                            <?php echo form_error('extension_zip', '<span class="text-danger">', '</span>'); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
         </form>
    </div>
</div>
<?php echo get_footer(); ?>