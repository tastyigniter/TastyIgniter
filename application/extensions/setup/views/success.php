<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $heading; ?></title>
	<link href="<?php echo base_url(APPPATH .'views/themes/admin/default/css/stylesheet.css'); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="setup_box">
	<h1>TastyIgniter</h1>
	<?php echo $alert; ?>
	<div class="content">
		<h2 style="text-align:center;">Installation Successful!</h2>
		<p style="text-align:center;">TastyIgniter has been installed sucessfully.</p>
		<p style="text-align:center;">Next Step:<br /> <?php echo $complete_setup; ?></p>
	</div>
</div>
</body>
</html>