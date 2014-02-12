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
	<div class="content">
	<h2>Server Requirements</h2>
	<p>Welcome to TastyIgniter! Any question listed below must be resolved before the installation can continue.</p>
	<?php echo $alert; ?>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" />
	<table align="" class="list">
		<tr>
			<td class="first">PHP Version (required 5.4+):</td>
			<td><?php echo $php_version; ?></td>
			<td><?php echo $php_status; ?></td>
		</tr>
		<tr>
			<td class="first">Register Globals:</td>
			<td><?php echo $register_globals_enabled; ?></td>
			<td><?php echo $register_globals_status; ?></td>
		</tr>
		<tr>
			<td class="first">Magic Quotes GPC:</td>
			<td><?php echo $magic_quotes_gpc_enabled; ?></td>
			<td><?php echo $magic_quotes_gpc_status; ?></td>
		</tr>
		<tr>
			<td class="first">File Uploads:</td>
			<td><?php echo $file_uploads_enabled; ?></td>
			<td><?php echo $file_uploads_status; ?></td>
		</tr>
		<tr>
			<td class="first">MySQL:</td>
			<td><?php echo $mysqli_installed; ?></td>
			<td><?php echo $mysqli_status; ?></td>
		</tr>
		<tr>
			<td class="first">cURL:</td>
			<td><?php echo $curl_installed; ?></td>
			<td><?php echo $curl_status; ?></td>
		</tr>
		<?php foreach ($writables as $writable) { ?>
		<tr>
			<td><?php echo $writable['file']; ?></td>
			<td><?php echo $is_writable; ?></td>
			<td><?php echo $writable['status']; ?></td>
		</tr>
		<?php } ?>  
		<tr>
			<td colspan="3"><input type="submit" name="submit" value="Continue" /></td>
		</tr>
	</table>
	</form>
	</div>
</div>
</body>
</html>