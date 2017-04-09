<form role="form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>" />
	<input type="hidden" name="requirements" value="1" />
	<table class="table table-bordered requirements">
		<tr>
			<td class="first">
				<strong><?php echo sprintf(lang('label_php_version'), $required_php_version); ?></strong>
				<span class="label label-info">NEW</span>
			</td>
			<td>
				<?php echo sprintf(lang('text_php_version'), $installed_php_version); ?>
				<input type="hidden" name="php_status" value="<?php echo $requirements['php_status']; ?>">
			</td>
			<td class="text-center"><?php echo (!$requirements['php_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_mysqli'); ?></strong></td>
			<td>
				<?php echo lang('text_mysqli_installed'); ?>
				<input type="hidden" name="mysqli_status" value="<?php echo $requirements['mysqli_status']; ?>">
			</td>
			<td class="text-center"><?php echo (!$requirements['mysqli_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first">
				<strong><?php echo lang('label_pdo'); ?></strong>
				<span class="label label-info">NEW</span>
			</td>
			<td>
				<?php echo lang('text_pdo_installed'); ?>
				<input type="hidden" name="pdo_status" value="<?php echo $requirements['pdo_status']; ?>">
			</td>
			<td class="text-center"><?php echo (!$requirements['pdo_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_curl'); ?></strong></td>
			<td>
				<?php echo lang('text_curl_installed'); ?>
				<input type="hidden" name="curl_status" value="<?php echo $requirements['curl_status']; ?>">
			</td>
			<td class="text-center"><?php echo (!$requirements['curl_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_gd'); ?></strong></td>
			<td>
				<?php echo lang('text_gd_installed'); ?>
				<input type="hidden" name="gd_status" value="<?php echo $requirements['gd_status']; ?>">
			</td>
			<td class="text-center"><?php echo (!$requirements['gd_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<tr>
			<td class="first"><strong><?php echo lang('label_zip'); ?></strong></td>
			<td>
				<?php echo lang('text_zip_installed'); ?>
				<input type="hidden" name="zip_status" value="<?php echo $requirements['zip_status']; ?>">
			</td>
			<td class="text-center"><?php echo (!$requirements['zip_status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<?php foreach ($writables as $writable) { ?>
		<tr>
			<td><strong><?php echo $writable['file']; ?></strong></td>
			<td>
				<?php echo lang('text_is_file_writable'); ?>
				<input type="hidden" name="files[]" value="<?php echo $writable['status']; ?>">
			</td>
			<td class="text-center"><?php echo (!$writable['status']) ? '<i class="fa fa-exclamation-triangle red"></i>' : '<i class="fa fa-circle green"></i>'; ?></td>
		</tr>
		<?php } ?>
	</table>
	<div class="buttons">
		<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
		<button type="submit" class="btn btn-success pull-right"><?php echo lang('button_continue'); ?></button>
	</div>
</form>