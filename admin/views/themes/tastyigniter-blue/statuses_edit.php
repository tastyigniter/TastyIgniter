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
							<input type="text" name="status_name" id="input-name" class="form-control" value="<?php echo set_value('status_name', $status_name); ?>" id="name" />
							<?php echo form_error('status_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-for" class="col-sm-3 control-label"><?php echo lang('label_for'); ?></label>
						<div class="col-sm-5">
							<select name="status_for" id="input-for" class="form-control">
								<?php if ($status_for === 'order') { ?>
									<option value="order" <?php echo set_select('status_for', 'order', TRUE); ?> ><?php echo lang('text_order'); ?></option>
									<option value="reserve" <?php echo set_select('status_for', 'reserve'); ?> ><?php echo lang('text_reservation'); ?></option>
								<?php } else if ($status_for === 'reserve') { ?>
									<option value="order" <?php echo set_select('status_for', 'order'); ?> ><?php echo lang('text_order'); ?></option>
									<option value="reserve" <?php echo set_select('status_for', 'reserve', TRUE); ?> ><?php echo lang('text_reservation'); ?></option>
								<?php } else { ?>
									<option value="order" <?php echo set_select('status_for', 'order'); ?> ><?php echo lang('text_order'); ?></option>
									<option value="reserve" <?php echo set_select('status_for', 'reserve'); ?> ><?php echo lang('text_reservation'); ?></option>
								<?php } ?>
							</select>
							<?php echo form_error('status_for', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
                    <div class="form-group">
                        <label for="input-color" class="col-sm-3 control-label"><?php echo lang('label_color'); ?></label>
                        <div class="col-sm-5">
                            <div class="input-group ti-color-picker">
                                <span class="input-group-addon"><i></i></span>
                                <input type="text" id="input-color" name="status_color" class="form-control" value="<?php echo set_value('status_color', $status_color); ?>">
                            </div>
                            <?php echo form_error('status_color', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
					<div class="form-group">
						<label for="input-comment" class="col-sm-3 control-label"><?php echo lang('label_comment'); ?></label>
						<div class="col-sm-5">
							<textarea name="status_comment" id="input-comment" class="form-control" rows="7"><?php echo set_value('status_comment', $status_comment); ?> </textarea>
							<?php echo form_error('status_comment', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo lang('label_notify'); ?>
							<span class="help-block"><?php echo lang('help_notify'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($notify_customer == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="notify_customer" value="0" <?php echo set_radio('notify_customer', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="notify_customer" value="1" <?php echo set_radio('notify_customer', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="notify_customer" value="0" <?php echo set_radio('notify_customer', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="notify_customer" value="1" <?php echo set_radio('notify_customer', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('notify_customer', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('.ti-color-picker').colorpicker();
});
//--></script>

<?php echo get_footer(); ?>