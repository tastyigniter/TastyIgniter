<form role="form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>" >
	<div class="form-group">
		<label for="input-db-name" class="col-sm-3 control-label"><?php echo lang('label_database'); ?></label>
		<div class="col-sm-9">
			<input type="text" name="database" id="input-db-name" class="form-control" value="<?php echo $database; ?>" />
			<span class="help-block"><?php echo lang('help_database'); ?></span>
			<?php echo form_error('database', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-db-host" class="col-sm-3 control-label"><?php echo lang('label_hostname'); ?></label>
		<div class="col-sm-9">
			<input type="text" name="hostname" id="input-db-host" class="form-control" value="<?php echo $hostname; ?>" />
			<span class="help-block"><?php echo lang('help_hostname'); ?></span>
			<?php echo form_error('hostname', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-db-user" class="col-sm-3 control-label"><?php echo lang('label_username'); ?></label>
		<div class="col-sm-9">
			<input type="text" name="username" id="input-db-user" class="form-control" value="<?php echo $username; ?>" />
			<span class="help-block"><?php echo lang('help_username'); ?></span>
			<?php echo form_error('username', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-db-pass" class="col-sm-3 control-label"><?php echo lang('label_password'); ?></label>
		<div class="col-sm-9">
			<input type="password" name="password" id="input-db-pass" class="form-control" value="<?php echo $password; ?>" />
			<span class="help-block"><?php echo lang('help_password'); ?></span>
			<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="input-db-prefix" class="col-sm-3 control-label"><?php echo lang('label_prefix'); ?></label>
		<div class="col-sm-9">
			<input type="text" name="dbprefix" id="input-db-prefix" class="form-control" value="<?php echo $dbprefix; ?>" />
			<span class="help-block"><?php echo lang('help_dbprefix'); ?></span>
			<?php echo form_error('dbprefix', '<span class="text-danger">', '</span>'); ?>
		</div>
	</div>

	<div class="buttons">
		<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
		<button type="submit" class="btn btn-success pull-right"><?php echo lang('button_continue'); ?></button>
	</div>
</form>