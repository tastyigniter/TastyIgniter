<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $heading; ?></title>
	<link type="image/ico" rel="shortcut icon" href="<?php echo base_url(APPPATH .'extensions/setup/views/assets/favicon.ico'); ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(APPPATH .'extensions/setup/views/assets/bootstrap.css'); ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(APPPATH .'extensions/setup/views/assets/font-awesome.css'); ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(APPPATH .'extensions/setup/views/assets/stylesheet.css'); ?>">
</head>
<body>
	<div class="container-fluid">
		<div class="page-header"><h1><?php echo $heading; ?></h1></div>
		<div class="row">
			<div class="col-md-7 setup_box">
				<div class="content">
					<h4>Database Settings</h4>
					<p>Please enter your database connection details below.</p>
					<div id="notification">
						<?php if (!empty($alert)) { ?>
							<?php echo $alert; ?>
						<?php } ?>
						<?php if (validation_errors()) { ?>
							<p class="alert alert-danger">Sorry but validation has failed, please check for errors.</p>
						<?php } ?>
					</div>
				
					<form role="form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" >
						<div class="form-group">
							<label for="input-db-name" class="col-sm-3 control-label">Database Name:</label>
							<div class="col-sm-8">
								<input type="text" name="db_name" id="input-db-name" class="form-control" value="<?php echo $db_name; ?>" />
								<span class="help-block">Enter the name of the database you want to use.</span>
								<?php echo form_error('db_name', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-db-host" class="col-sm-3 control-label">Hostname:</label>
							<div class="col-sm-8">
								<input type="text" name="db_host" id="input-db-host" class="form-control" value="<?php echo $db_host; ?>" />
								<span class="help-block">Enter the database host name.</span>
								<?php echo form_error('db_host', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group"> 
							<label for="input-db-user" class="col-sm-3 control-label">Username:</label>
							<div class="col-sm-8">
								<input type="text" name="db_user" id="input-db-user" class="form-control" value="<?php echo $db_user; ?>" />
								<span class="help-block">Enter the database username.</span>
								<?php echo form_error('db_user', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-db-pass" class="col-sm-3 control-label">Password:</label>
							<div class="col-sm-8">
								<input type="password" name="db_pass" id="input-db-pass" class="form-control" value="<?php echo $db_pass; ?>" />
								<span class="help-block">Enter the database password. Make sure to use a strong password.</span>
								<?php echo form_error('db_pass', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-db-prefix" class="col-sm-3 control-label">Prefix:</label>
							<div class="col-sm-8">
								<input type="text" name="db_prefix" id="input-db-prefix" class="form-control" value="<?php echo $db_prefix; ?>" />
								<?php echo form_error('db_prefix', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>

						<button type="submit" class="btn btn-success">Continue</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>