<form role="form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>" />
	<input type="hidden" name="requirements" value="1" />
	<table class="table table-bordered requirements">
		<tr>
			<td class="first"><strong><?php echo sprintf(lang('label_php_version'), $required_php_version); ?></strong></td>
			<td><?php echo sprintf(lang('text_php_version'), $installed_php_version); ?></td>
			<td class="text-center"><?php echo (!$requirements['php_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_register_globals'); ?></strong></td>
			<td><?php echo lang('text_register_globals_enabled'); ?></td>
			<td class="text-center"><?php echo (!$requirements['register_globals_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_magic_quotes'); ?></strong></td>
			<td><?php echo lang('text_magic_quotes_enabled'); ?></td>
			<td class="text-center"><?php echo (!$requirements['magic_quotes_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_file_uploads'); ?></strong></td>
			<td><?php echo lang('text_file_uploads_enabled'); ?></td>
			<td class="text-center"><?php echo (!$requirements['file_uploads_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_mysqli'); ?></strong></td>
			<td><?php echo lang('text_mysqli_installed'); ?></td>
			<td class="text-center"><?php echo (!$requirements['mysqli_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_curl'); ?></strong></td>
			<td><?php echo lang('text_curl_installed'); ?></td>
			<td class="text-center"><?php echo (!$requirements['curl_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_gd'); ?></strong></td>
			<td><?php echo lang('text_gd_installed'); ?></td>
			<td class="text-center"><?php echo (!$requirements['gd_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<?php foreach ($writables as $writable) { ?>
		<tr>
			<td><strong><?php echo $writable['file']; ?></strong></td>
			<td><?php echo lang('text_is_file_writable'); ?></td>
			<td class="text-center"><?php echo (!$writable['status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<?php } ?>
	</table>
	<div class="buttons">
		<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
		<button type="submit" class="btn btn-success pull-right"><?php echo lang('button_continue'); ?></button>
	</div>
</form>