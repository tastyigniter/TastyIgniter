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
					<h4>Server Requirements</h4>
					<p>Any question listed below must be resolved before the installation can continue.</p>
					<div id="notification">
						<?php if (!empty($alert)) { ?>
							<?php echo $alert; ?>
						<?php } ?>
					</div>
					
					<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" />
						<input type="hidden" name="requirements" value="" />
						<table class="table table-bordered">
							<tr>
								<td class="first">PHP Version (required 5.4+):</td>
								<td><?php echo $php_version; ?></td>
								<td class="text-center"><?php echo $php_status; ?></td>
							</tr>
							<tr>
								<td class="first">Register Globals:</td>
								<td><?php echo $register_globals_enabled; ?></td>
								<td class="text-center"><?php echo $register_globals_status; ?></td>
							</tr>
							<tr>
								<td class="first">Magic Quotes GPC:</td>
								<td><?php echo $magic_quotes_gpc_enabled; ?></td>
								<td class="text-center"><?php echo $magic_quotes_gpc_status; ?></td>
							</tr>
							<tr>
								<td class="first">File Uploads:</td>
								<td><?php echo $file_uploads_enabled; ?></td>
								<td class="text-center"><?php echo $file_uploads_status; ?></td>
							</tr>
							<tr>
								<td class="first">MySQL:</td>
								<td><?php echo $mysqli_installed; ?></td>
								<td class="text-center"><?php echo $mysqli_status; ?></td>
							</tr>
							<tr>
								<td class="first">cURL:</td>
								<td><?php echo $curl_installed; ?></td>
								<td class="text-center"><?php echo $curl_status; ?></td>
							</tr>
							<tr>
								<td class="first">GD/GD2:</td>
								<td><?php echo $gd_installed; ?></td>
								<td class="text-center"><?php echo $gd_status; ?></td>
							</tr>
							<?php foreach ($writables as $writable) { ?>
							<tr>
								<td><?php echo $writable['file']; ?></td>
								<td><?php echo $is_writable; ?></td>
								<td class="text-center"><?php echo $writable['status']; ?></td>
							</tr>
							<?php } ?>  
						</table>

						<button type="submit" class="btn btn-success">Continue</button>
					</form>
				</div>
	</div>
			</div>
		</div>
	</div>
</body>
</html>