<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $heading; ?></title>
	<link href="<?php echo base_url(APPPATH .'views/themes/admin/default/css/stylesheet.css'); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="setup_box">
	<h1>TastyIgniter - Setup</h1>
	<div class="content">
	<h2>Database Settings</h2>
	<p>Please enter your database connection details below.</p>
	<div id="notification"><?php echo validation_errors('<span class="error">', '</span>'); ?></div>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" />
	<table align="" class="form">
		<tr>
			<td class="first">Database Name:</td>
			<td><input type="text" name="db_name" value="<?php echo $db_name; ?>" /></td>
		</tr>
		<tr>
			<td class="first">Hostname:</td>
			<td><input type="text" name="db_host" value="<?php echo $db_host; ?>" /></td>
		</tr>
		<tr>
			<td class="first">Username:</td>
			<td><input type="text" name="db_user" value="<?php echo $db_user; ?>" /></td>
		</tr>
		<tr>
			<td class="first">Password:</td>
			<td><input type="password" name="db_pass" value="<?php echo $db_pass; ?>" /></td>
		</tr>
		<tr>
			<td class="first">Prefix:</td>
			<td><input type="text" name="db_prefix" value="<?php echo $db_prefix; ?>" /></td>
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