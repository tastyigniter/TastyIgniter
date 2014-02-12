<div class="box">
	<div id="update-box">
	<form accept-charset="utf-8" method="post" action="<?php echo site_url('admin/backup'); ?>" enctype="multipart/form-data" id="restore" style="border-bottom:1px solid #ddd;margin-bottom:20px;padding-bottom:5px;">
	<table class="form">
		<tr>
			<td><b>Restore:</b></td>
			<td><input type="file" name="import" value="" id="photo" /></td>
		</tr>
  	</table>
	</form>

	<form accept-charset="utf-8" method="post" action="<?php echo site_url('admin/backup/export'); ?>" enctype="multipart/form-data" id="backup">
	<table class="form">
		<tr>
			<td><b>Backup:</b></td>
			<td><div class="selectbox">
			<table class="db_tables">
			<?php foreach ($db_tables as $key => $value) { ?>
			<tr>
				<td width="1"><input type="checkbox" name="backup[]" value="<?php echo $value; ?>" <?php echo set_checkbox('backup[]', $value); ?> /></td>
				<td><label for=""><?php echo $value; ?></label></td>
			</tr>
			<?php } ?>
			</table></div>
			<a onclick="$(this).parent().find(':checkbox').attr('checked', true);">Select All</a>&nbsp;&nbsp;/&nbsp;&nbsp;
			<a onclick="$(this).parent().find(':checkbox').attr('checked', false);">Unselect All</a>		
			</td>
			<td></td>
		</tr>
  	</table>
	</form>
	</div>
</div>