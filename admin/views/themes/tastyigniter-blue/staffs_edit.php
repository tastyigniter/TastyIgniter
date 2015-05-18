<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#staff-details" data-toggle="tab">Staff Details</a></li>
				<li><a href="#basic-settings" data-toggle="tab">Basic Settings</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="staff-details" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="staff_name" id="input-name" class="form-control" value="<?php echo set_value('staff_name', $staff_name); ?>" />
							<?php echo form_error('staff_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email" class="col-sm-3 control-label">Email:</label>
						<div class="col-sm-5">
							<input type="text" name="staff_email" id="input-email" class="form-control" value="<?php echo set_value('staff_email', $staff_email); ?>" />
							<?php echo form_error('staff_email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-username" class="col-sm-3 control-label">Username:
							<span class="help-block">Username can not be changed.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="username" id="input-username" class="form-control" value="<?php echo set_value('username', $username); ?>" />
							<?php echo form_error('username', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-password" class="col-sm-3 control-label">Password:
							<span class="help-block">Leave blank to leave password unchanged.</span>
						</label>
						<div class="col-sm-5">
							<input type="password" name="password" id="input-password" class="form-control" value="" id="password" autocomplete="off" />
							<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Password Confirm:</label>
						<div class="col-sm-5">
							<input type="password" name="password_confirm" id="" class="form-control" id="password_confirm" autocomplete="off" />
							<?php echo form_error('password_confirm', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Status:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($staff_status == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="staff_status" value="0" <?php echo set_radio('staff_status', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="staff_status" value="1" <?php echo set_radio('staff_status', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="staff_status" value="0" <?php echo set_radio('staff_status', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="staff_status" value="1" <?php echo set_radio('staff_status', '1'); ?>>Enabled</label>
								<?php } ?>
							</div>
							<?php echo form_error('staff_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="basic-settings" class="tab-pane row wrap-all">
					<?php if ($display_staff_group) { ?>
						<div class="form-group">
							<label for="input-group" class="col-sm-3 control-label">Staff Group:</label>
							<div class="col-sm-5">
								<select name="staff_group" id="input-group" class="form-control">
								<option value="">— Select —</option>
								<?php foreach ($staff_groups as $staff_group) { ?>
									<?php if ($staff_group['staff_group_id'] === $staff_group_id) { ?>
										<option value="<?php echo $staff_group['staff_group_id']; ?>" <?php echo set_select('staff_group', $staff_group['staff_group_id'], TRUE); ?> ><?php echo $staff_group['staff_group_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $staff_group['staff_group_id']; ?>" <?php echo set_select('staff_group', $staff_group['staff_group_id']); ?> ><?php echo $staff_group['staff_group_name']; ?></option>
									<?php } ?>
								<?php } ?>
								</select>
								<?php echo form_error('staff_group', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-location" class="col-sm-3 control-label">Location:</label>
							<div class="col-sm-5">
								<select name="staff_location_id" id="input-location" class="form-control">
									<option value="0">Use Default</option>
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
					<div class="form-group">
						<label for="input-timezone" class="col-sm-3 control-label">Timezone:</label>
						<div class="col-sm-5">
							<select name="timezone" id="input-timezone" class="form-control">
								<option value="0">Use Default</option>
								<?php foreach ($timezones as $key => $value) { ?>
									<?php if ($key === $timezone) { ?>
										<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
									<?php } else { ?>
										<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('timezone', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-language" class="col-sm-3 control-label">Language:</label>
						<div class="col-sm-5">
							<select name="language_id" id="input-language" class="form-control">
								<option value="0">Use Default</option>
								<?php foreach ($languages as $language) { ?>
									<?php if ($language['language_id'] === $language_id) { ?>
										<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('language_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>