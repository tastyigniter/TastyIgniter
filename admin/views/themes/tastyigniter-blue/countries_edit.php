<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="country_name" id="input-name" class="form-control" value="<?php echo set_value('country_name', $country_name); ?>" />
							<?php echo form_error('country_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-iso-code-2" class="col-sm-3 control-label"><?php echo lang('label_iso_code2'); ?>
							<span class="help-block"><?php echo lang('help_iso'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="iso_code_2" id="input-iso-code-2" class="form-control" value="<?php echo set_value('iso_code_2', $iso_code_2); ?>" size="5" />
							<?php echo form_error('iso_code_2', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-iso-code-3" class="col-sm-3 control-label"><?php echo lang('label_iso_code3'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="iso_code_3" id="input-iso-code-3" class="form-control" value="<?php echo set_value('iso_code_3', $iso_code_3); ?>" size="5" />
							<?php echo form_error('iso_code_3', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-flag" class="col-sm-3 control-label"><?php echo lang('label_flag'); ?></label>
						<div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon lg-addon" title="<?php echo $flag['name']; ?>">
                                    <i><img class="thumb img-responsive" id="input-flag-thumb" width="24px" src="<?php echo $flag['path']; ?>"></i>
                                </span>
                                <input type="text" class="form-control" id="input-flag" value="<?php echo set_value('flag', $flag['input']); ?>" name="flag">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" onclick="mediaManager('input-flag');" type="button"><i class="fa fa-picture-o"></i></button>
                                    <button class="btn btn-danger" onclick="$('#input-flag-thumb').attr('src', '<?php echo $no_photo; ?>'); $('#input-flag').attr('value', '');" type="button"><i class="fa fa-times-circle"></i></button>
                                </span>
                            </div>
							<?php echo form_error('flag', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-format" class="col-sm-3 control-label"><?php echo lang('label_format'); ?>
							<span class="help-block"><?php echo lang('help_format'); ?></span>
						</label>
						<div class="col-sm-5">
							<textarea name="format" id="input-format" class="form-control" rows="5"><?php echo set_value('format', $format); ?></textarea>
							<?php echo form_error('format', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>