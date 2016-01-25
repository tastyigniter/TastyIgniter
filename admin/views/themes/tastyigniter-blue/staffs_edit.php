<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#staff-details" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#basic-settings" data-toggle="tab"><?php echo lang('text_tab_setting'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="staff-details" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="staff_name" id="input-name" class="form-control" value="<?php echo set_value('staff_name', $staff_name); ?>" />
							<?php echo form_error('staff_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email" class="col-sm-3 control-label"><?php echo lang('label_email'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="staff_email" id="input-email" class="form-control" value="<?php echo set_value('staff_email', $staff_email); ?>" />
							<?php echo form_error('staff_email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-username" class="col-sm-3 control-label"><?php echo lang('label_username'); ?>
							<span class="help-block"><?php echo lang('help_username'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="username" id="input-username" class="form-control" value="<?php echo set_value('username', $username); ?>" />
							<?php echo form_error('username', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-password" class="col-sm-3 control-label"><?php echo lang('label_password'); ?>
							<span class="help-block"><?php echo lang('help_password'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="password" name="password" id="input-password" class="form-control" value="" id="password" autocomplete="off" />
							<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_confirm_password'); ?></label>
						<div class="col-sm-5">
							<input type="password" name="password_confirm" id="" class="form-control" id="password_confirm" autocomplete="off" />
							<?php echo form_error('password_confirm', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($staff_status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="staff_status" value="0" <?php echo set_radio('staff_status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="staff_status" value="1" <?php echo set_radio('staff_status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="staff_status" value="0" <?php echo set_radio('staff_status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="staff_status" value="1" <?php echo set_radio('staff_status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('staff_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="basic-settings" class="tab-pane row wrap-all">
					<?php if ($display_staff_group) { ?>
						<div class="form-group">
							<label for="input-group" class="col-sm-3 control-label"><?php echo lang('label_group'); ?></label>
							<div class="col-sm-5">
								<select name="staff_group_id" id="input-group" class="form-control">
								<option value=""><?php echo lang('text_please_select'); ?></option>
								<?php foreach ($staff_groups as $staff_group) { ?>
									<?php if ($staff_group['staff_group_id'] === $staff_group_id) { ?>
										<option value="<?php echo $staff_group['staff_group_id']; ?>" <?php echo set_select('staff_group_id', $staff_group['staff_group_id'], TRUE); ?> ><?php echo $staff_group['staff_group_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $staff_group['staff_group_id']; ?>" <?php echo set_select('staff_group_id', $staff_group['staff_group_id']); ?> ><?php echo $staff_group['staff_group_name']; ?></option>
									<?php } ?>
								<?php } ?>
								</select>
								<?php echo form_error('staff_group_id', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-location" class="col-sm-3 control-label"><?php echo lang('label_location'); ?></label>
							<div class="col-sm-5">
								<select name="staff_location_id" id="input-location" class="form-control">
									<option value="0"><?php echo lang('text_use_default'); ?></option>
									<?php foreach ($locations as $location) { ?>
									<?php if ($location['location_id'] === $staff_location_id) { ?>
										<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
								<?php echo form_error('staff_location_id', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>