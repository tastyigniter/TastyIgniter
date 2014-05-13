<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $heading; ?></title>
	<?php echo link_tag('assets/css/admin_styles.css'); ?>
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