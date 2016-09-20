<form role="form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>" >
	<h5><?php echo lang('text_restaurant_details'); ?></h5>
	<hr>
	<div class="form-group">
		<label for="input-site-location-mode" class="col-sm-3 control-label"><?php echo lang('label_site_location_mode'); ?></label>
		<div class="col-sm-9">
			<div class="btn-group" data-toggle="buttons">
				<label class="btn btn-default <?php echo ($site_location_mode === 'single') ? 'active' : '' ?>">
					<input type="radio" name="site_location_mode" value="single" <?php echo set_radio('site_location_mode', 'single', ($site_location_mode === 'single')); ?>>
					<?php echo lang('text_single_location'); ?>
				</label>
				<label class="btn btn-default <?php echo ($site_location_mode !== 'single') ? 'active' : '' ?>">
					<input type="radio" name="site_location_mode" value="multiple" <?php echo set_radio('site_location_mode', 'multiple', ($site_location_mode !== 'single')); ?>>
					<?php echo lang('text_multi_location'); ?>
				</label>
			</div>
			<span class="help-block"><?php echo lang('help_site_location_mode'); ?></span>
			<?php echo form_error('site_location_mode', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-site-name" class="col-sm-3 control-label"><?php echo lang('label_site_name'); ?></label>
		<div class="col-sm-9">
			<input type="text" name="site_name" id="input-site-name" class="form-control" value="<?php echo $site_name; ?>" />
			<?php echo form_error('site_name', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-site-email" class="col-sm-3 control-label"><?php echo lang('label_site_email'); ?></label>
		<div class="col-sm-9">
			<input type="text" name="site_email" id="input-site-email" class="form-control" value="<?php echo $site_email; ?>" />
			<?php echo form_error('site_email', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<br />

	<h5><?php echo lang('text_admin_details'); ?></h5>
	<hr>
	<div class="form-group">
		<label for="input-staff-name" class="col-sm-3 control-label"><?php echo lang('label_staff_name'); ?></label>
		<div class="col-sm-9">
			<input type="text" name="staff_name" id="input-staff-name" class="form-control" value="<?php echo $staff_name; ?>" />
			<?php echo form_error('staff_name', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-username" class="col-sm-3 control-label"><?php echo lang('label_admin_username'); ?></label>
		<div class="col-sm-9">
			<input type="text" name="username" id="input-username" class="form-control" value="<?php echo $username; ?>" />
			<?php echo form_error('username', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-password" class="col-sm-3 control-label"><?php echo lang('label_admin_password'); ?></label>
		<div class="col-sm-9">
			<input type="password" name="password" id="input-password" class="form-control" value="<?php echo $password; ?>" />
			<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-confirm-password" class="col-sm-3 control-label"><?php echo lang('label_confirm_password'); ?></label>
		<div class="col-sm-9">
			<input type="password" name="confirm_password" id="input-confirm-password" class="form-control" value="" />
			<?php echo form_error('confirm_password', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-demo-data" class="col-sm-3 control-label"><?php echo lang('label_demo_data'); ?></label>
		<div class="col-sm-9">
			<div class="btn-group" data-toggle="buttons">
				<label class="btn btn-default <?php echo ($demo_data != '1') ? 'active' : '' ?>">
					<input type="radio" name="demo_data" value="0" <?php echo set_radio('demo_data', '0', ($demo_data != '1')); ?>>
					<?php echo lang('text_no'); ?>
				</label>
				<label class="btn btn-default <?php echo ($demo_data == '1') ? 'active' : '' ?>">
					<input type="radio" name="demo_data" value="1" <?php echo set_radio('demo_data', '1', ($demo_data == '1')); ?>>
					<?php echo lang('text_yes'); ?>
				</label>
			</div>
			<?php echo form_error('demo_data', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>

	<div class="buttons">
		<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
		<button type="submit" class="btn btn-success pull-right"><?php echo lang('button_continue'); ?></button>
	</div>
</form>