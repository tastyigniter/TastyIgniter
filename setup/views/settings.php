<form role="form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" >
	<div class="form-group">
		<label for="input-site-name" class="col-sm-4 control-label">Restaurant name:</label>
		<div class="col-sm-8">
			<input type="text" name="site_name" id="input-site-name" class="form-control" value="<?php echo $site_name; ?>" />
			<?php echo form_error('site_name', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-site-email" class="col-sm-4 control-label">Restaurant email:</label>
		<div class="col-sm-8">
			<input type="text" name="site_email" id="input-site-email" class="form-control" value="<?php echo $site_email; ?>" />
			<?php echo form_error('site_email', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<br />

	<h4>Admin Details</h4>
	<div class="form-group">
		<label for="input-staff-name" class="col-sm-4 control-label">Name:</label>
		<div class="col-sm-8">
			<input type="text" name="staff_name" id="input-staff-name" class="form-control" value="<?php echo $staff_name; ?>" />
			<?php echo form_error('staff_name', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-username" class="col-sm-4 control-label">Username:</label>
		<div class="col-sm-8">
			<input type="text" name="username" id="input-username" class="form-control" value="<?php echo $username; ?>" />
			<?php echo form_error('username', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-password" class="col-sm-4 control-label">Password:</label>
		<div class="col-sm-8">
			<input type="password" name="password" id="input-password" class="form-control" value="<?php echo $password; ?>" />
			<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-confirm-password" class="col-sm-4 control-label">Confirm password:</label>
		<div class="col-sm-8">
			<input type="password" name="confirm_password" id="input-confirm-password" class="form-control" value="" />
			<?php echo form_error('confirm_password', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>

	<a class="btn btn-danger" href="<?php echo $back_url; ?>">Back</a>
	<button type="submit" class="btn btn-success pull-right">Continue</button>
</form>