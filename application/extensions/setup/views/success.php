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
					<div id="notification">
						<?php if (!empty($alert)) { ?>
							<?php echo $alert; ?>
						<?php } ?>
					</div>
				
					<h4>Installation Successful!</h4>
					<p class="well">TastyIgniter has been installed sucessfully.<br /><br />
					<b>Next Step:</b><br /> <?php echo $complete_setup; ?></p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>