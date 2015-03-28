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
					<h4>Configuration</h4>
					<p>Please fill in the following information. You’ll be able to change the settings later.</p>
					<div id="notification">
						<?php if (!empty($alert)) { ?>
							<?php echo $alert; ?>
						<?php } ?>
						<?php if (validation_errors()) { ?>
							<p class="alert alert-danger">Sorry but validation has failed, please check for errors.</p>
						<?php } ?>
					</div>
				
					<br />
					<form role="form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" >
						<div class="form-group">
							<label for="input-site-name" class="col-sm-3 control-label">Restaurant name:</label>
							<div class="col-sm-8">
								<input type="text" name="site_name" id="input-site-name" class="form-control" value="<?php echo $site_name; ?>" />
								<?php echo form_error('site_name', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-site-email" class="col-sm-3 control-label">Restaurant email:</label>
							<div class="col-sm-8">
								<input type="text" name="site_email" id="input-site-email" class="form-control" value="<?php echo $site_email; ?>" />
								<?php echo form_error('site_email', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<br />
					
						<h4>Admin Details</h4>
						<div class="form-group">
							<label for="input-staff-name" class="col-sm-3 control-label">Name:</label>
							<div class="col-sm-8">
								<input type="text" name="staff_name" id="input-staff-name" class="form-control" value="<?php echo $staff_name; ?>" />
								<?php echo form_error('staff_name', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-username" class="col-sm-3 control-label">Username:</label>
							<div class="col-sm-8">
								<input type="text" name="username" id="input-username" class="form-control" value="<?php echo $username; ?>" />
								<?php echo form_error('username', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-password" class="col-sm-3 control-label">Password:</label>
							<div class="col-sm-8">
								<input type="password" name="password" id="input-password" class="form-control" value="<?php echo $password; ?>" />
								<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-confirm-password" class="col-sm-3 control-label">Confirm password:</label>
							<div class="col-sm-8">
								<input type="password" name="confirm_password" id="input-confirm-password" class="form-control" value="" />
								<?php echo form_error('confirm_password', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-demo-data" class="col-sm-3 control-label">Include demo data:</label>
							<div class="col-sm-8">
								<div class="checkbox">
									<input type="checkbox" name="demo_data" value="1">
									<?php echo form_error('demo_data', '<span class="error help-block">', '</span>'); ?>
								</div>
							</div>
						</div>

						<button type="submit" class="btn btn-success">Continue</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>