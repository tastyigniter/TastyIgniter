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
						<td><b>Title:</b></td>
						<td><input type="text" name="currency_name" value="<?php echo set_value('currency_name', $currency_name); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Country:</b></td>
						<td><select name="country_id">
						<?php foreach ($countries as $country) { ?>
						<?php if ($country['country_id'] === $country_id) { ?>
							<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
						<?php } else { ?>  
							<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
						<?php } ?>  
						<?php } ?>  
						</select></td>
					</tr>
					<tr>
						<td><b>Code:</b></td>
						<td><input type="text" name="currency_code" value="<?php echo set_value('currency_code', $currency_code); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Symbol:</b></td>
						<td><input type="text" name="currency_symbol" value="<?php echo set_value('currency_symbol', $currency_symbol); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>ISO Alpha 2:</b></td>
						<td><input type="text" name="iso_alpha2" value="<?php echo set_value('iso_alpha2', $iso_alpha2); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>ISO Alpha 3:</b></td>
						<td><input type="text" name="iso_alpha3" value="<?php echo set_value('iso_alpha3', $iso_alpha3); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>ISO Numeric:</b></td>
						<td><input type="text" name="iso_numeric" value="<?php echo set_value('iso_numeric', $iso_numeric); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Status:</b></td>
						<td><select name="currency_status">
							<option value="0" <?php echo set_select('currency_status', '0'); ?> >Disabled</option>
						<?php if ($currency_status === '1') { ?>
							<option value="1" <?php echo set_select('currency_status', '1', TRUE); ?> >Enabled</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('currency_status', '1'); ?> >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	</div>
</div>