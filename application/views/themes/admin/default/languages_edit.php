<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general" class="active">Details</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table align=""class="form">
				<tbody>
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="name" value="<?php echo set_value('name', $name); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Language Code:</b><br />
						<font size="1">Language url code</font></td>
						<td><input type="text" name="code" value="<?php echo set_value('code', $code); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Image Icon:</b><br />
						<font size="1">Language image filename</font></td>
						<td><select name="image">
							<?php foreach ($flags as $flag) { ?>
							<?php if ($flag['file'] === $image) { ?>
								<option value="<?php echo $flag['file']; ?>" selected="selected"><?php echo $flag['name']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $flag['file']; ?>"><?php echo $flag['name']; ?></option>
							<?php } ?>
							<?php } ?>
							</select>
							<img id="flag" alt="<?php echo $image; ?>" src="<?php echo $image_url; ?>" width="24" height="12" />
						</td>
					</tr>
					<tr>
						<td><b>Directory Name:</b><br />
						<font size="1">Language directory name.</font></td>
						<td><input type="text" name="directory" value="<?php echo set_value('directory', $directory); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Status:</b></td>
						<td><select name="status">
						<?php if ($status === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
							<option value="0">Disabled</option>
						<?php } else { ?>
							<option value="1">Enabled</option>
							<option value="0" selected="selected">Disabled</option>
						<?php } ?>
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
$('select[name="image"]').change(function() {
	var value = $('select[name="image"]').val();
	var html  = '<?php echo base_url(APPPATH. "views/themes/admin/default/images/flags"); ?>/' + value;
	$('#flag').attr('src', html);
});

$('select[name="image"]').trigger('change');
//--></script> 
<script type="text/javascript"><!--