<form role="form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>" >
	<div class="form-group">
		<label for="input-db-name" class="col-sm-4 control-label">Database Name:</label>
		<div class="col-sm-8">
			<input type="text" name="db_name" id="input-db-name" class="form-control" value="<?php echo $db_name; ?>" />
			<span class="help-block">Enter the name of the database you want to use.</span>
			<?php echo form_error('db_name', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-db-host" class="col-sm-4 control-label">Hostname:</label>
		<div class="col-sm-8">
			<input type="text" name="db_host" id="input-db-host" class="form-control" value="<?php echo $db_host; ?>" />
			<span class="help-block">Enter the database host name.</span>
			<?php echo form_error('db_host', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-db-user" class="col-sm-4 control-label">Username:</label>
		<div class="col-sm-8">
			<input type="text" name="db_user" id="input-db-user" class="form-control" value="<?php echo $db_user; ?>" />
			<span class="help-block">Enter the database username.</span>
			<?php echo form_error('db_user', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-db-pass" class="col-sm-4 control-label">Password:</label>
		<div class="col-sm-8">
			<input type="password" name="db_pass" id="input-db-pass" class="form-control" value="<?php echo $db_pass; ?>" />
			<span class="help-block">Enter the database password. Make sure to use a strong password.</span>
			<?php echo form_error('db_pass', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-db-prefix" class="col-sm-4 control-label">Prefix:</label>
		<div class="col-sm-8">
			<input type="text" name="db_prefix" id="input-db-prefix" class="form-control" value="<?php echo $db_prefix; ?>" />
			<?php echo form_error('db_prefix', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-demo-data" class="col-sm-4 control-label">Include demo data:</label>
		<div class="col-sm-8">
			<div class="checkbox">
				<input type="checkbox" name="demo_data" value="1">
				<?php echo form_error('demo_data', '<span class="text-danger">', '</span>'); ?>
			</div>
		</div>
	</div>

	<a class="btn btn-danger" href="<?php echo $back_url; ?>">Back</a>
	<button type="submit" class="btn btn-success pull-right">Continue</button>
</form>