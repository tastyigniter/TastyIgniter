<div class="box">
	<div id="update-box">
	<form accept-charset="utf-8" method="post" action="<?php echo site_url('admin/backup'); ?>" enctype="multipart/form-data" id="backup">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general" class="active">Database</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="list">
				<thead>
					<tr>
						<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'backup\']').prop('checked', this.checked);"></th>
						<th>Table Name</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($db_tables as $key => $value) { ?>
					<tr>
						<td><input type="checkbox" name="backup[]" value="<?php echo $value; ?>" <?php echo set_checkbox('backup[]', $value); ?> /></td>
						<td><label for=""><?php echo $value; ?></label></td>
						<td></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</form>
	</div>
</div>