<form accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>" />
	<input type="hidden" name="requirements" value="1" />
	<table class="table table-striped requirements">
		<tr>
			<td class="first"><?php echo sprintf(lang('label_php_version'), $required_php_version); ?></td>
			<td><?php echo sprintf(lang('text_php_version'), $installed_php_version); ?></td>
			<td class="text-center"><?php echo (!$requirements['php_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-check-square-o green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><?php echo lang('label_register_globals'); ?></td>
			<td><?php echo lang('text_register_globals_enabled'); ?></td>
			<td class="text-center"><?php echo (!$requirements['register_globals_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-check-square-o green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><?php echo lang('label_magic_quotes'); ?></td>
			<td><?php echo lang('text_magic_quotes_enabled'); ?></td>
			<td class="text-center"><?php echo (!$requirements['magic_quotes_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-check-square-o green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><?php echo lang('label_file_uploads'); ?></td>
			<td><?php echo lang('text_file_uploads_enabled'); ?></td>
			<td class="text-center"><?php echo (!$requirements['file_uploads_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-check-square-o green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><?php echo lang('label_mysqli'); ?></td>
			<td><?php echo lang('text_mysqli_installed'); ?></td>
			<td class="text-center"><?php echo (!$requirements['mysqli_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-check-square-o green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><?php echo lang('label_curl'); ?></td>
			<td><?php echo lang('text_curl_installed'); ?></td>
			<td class="text-center"><?php echo (!$requirements['curl_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-check-square-o green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><?php echo lang('label_gd'); ?></td>
			<td><?php echo lang('text_gd_installed'); ?></td>
			<td class="text-center"><?php echo (!$requirements['gd_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-check-square-o green"></i>'; ?></td>
		</tr>
		<?php foreach ($writables as $writable) { ?>
		<tr>
			<td><?php echo $writable['file']; ?></td>
			<td><?php echo lang('text_is_file_writable'); ?></td>
			<td class="text-center"><?php echo (!$writable['status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-check-square-o green"></i>'; ?></td>
		</tr>
		<?php } ?>
	</table>
	<div class="buttons">
		<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
		<button type="submit" class="btn btn-success pull-right"><?php echo lang('button_continue'); ?></button>
	</div>
</form>