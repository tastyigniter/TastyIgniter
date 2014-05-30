<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="update-box">
	<form accept-charset="utf-8" method="post" action="<?php echo site_url('admin/restore'); ?>" enctype="multipart/form-data">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general" class="active">Database</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Restore:</b></td>
						<td><input type="file" name="restore" value="" id="" /></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
	</div>
</div>