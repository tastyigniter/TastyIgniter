<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $heading; ?></title>
	<?php echo link_tag('assets/css/admin_styles.css'); ?>
</head>
<body>
<div class="setup_box">
	<h1>TastyIgniter - Setup</h1>
	<div class="content">
	<p>Please fill in the following information. You’ll be able to change the settings later.</p>
	<div id="notification"><?php echo validation_errors('<span class="error">', '</span>'); ?></div>
	<h2>Configuration</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" />
	<table align=""class="form">
		<tr>
			<td><b>Restaurant Name:</b></td>
			<td><input type="text" name="site_name" value="<?php echo $site_name; ?>" /></td>
		</tr>
		<tr>
			<td><b>Restaurant Email:</b></td>
			<td><input type="text" name="site_email" value="<?php echo $site_email; ?>" /></td>
		</tr>
	</table>
	<h2>Admin Details</h2>
	<table align=""class="form">
		<tr>
			<td><b>Name:</b></td>
			<td><input type="text" name="staff_name" value="<?php echo $staff_name; ?>" /></td>
		</tr>
		<tr>
			<td><b>Username:</b></td>
			<td><input type="text" name="username" value="<?php echo $username; ?>" /></td>
		</tr>
		<tr>
			<td><b>Password:</b></td>
			<td><input type="password" name="password" value="<?php echo $password; ?>" /></td>
		</tr>
		<tr>
			<td><b>Confirm Password:</b></td>
			<td><input type="password" name="confirm_password" value="" /></td>
		</tr>
	</table>
	<br />
	
	<div>
		<input type="submit" name="submit" value="Continue" />
	</div>
	</form>
	</div>
</div>
</body>
</html>