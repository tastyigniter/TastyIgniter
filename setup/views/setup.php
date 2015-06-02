<form accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>" />
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
		<tr>
			<td colspan="3">
				<button type="submit" class="btn btn-success pull-right">Continue</button>
			</td>
		</tr>
	</table>
</form>