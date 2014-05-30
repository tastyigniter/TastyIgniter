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
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general" class="active">Details</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Country:</b></td>
						<td><input type="text" name="country_name" value="<?php echo set_value('country_name', $country_name); ?>" class="textfield" /></td>
						<td></td>
					</tr>
					<tr>
						<td><b>ISO Code 2:</b></td>
						<td><input type="text" name="iso_code_2" value="<?php echo set_value('iso_code_2', $iso_code_2); ?>" class="textfield" size="5" /></td>
						<td></td>
					</tr>
					<tr>
						<td><b>ISO Code 3:</b></td>
						<td><input type="text" name="iso_code_3" value="<?php echo set_value('iso_code_3', $iso_code_3); ?>" class="textfield" size="5" /></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Format:</b><br />
						<font size="1">Address 1 = {address_1}<br />Address 2 = {address_2}<br />City = {city}<br />Postcode = {postcode}<br />State = {state}<br />Country = {country}</font></td>
						<td><textarea name="format" cols="50" rows="7"><?php echo set_value('format', $format); ?></textarea></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Status:</b></td>
						<td><select name="status">
							<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
						<?php if ($status === '1') { ?>
							<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
	</div>
</div>