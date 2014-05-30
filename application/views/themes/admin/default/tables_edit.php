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
				<li><a class="active" rel="#table-details">Table Details</a></li>
			</ul>
		</div>

		<div id="table-details" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="table_name" value="<?php echo set_value('table_name', $table_name); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Minimum:</b></td>
						<td><input type="text" name="min_capacity" value="<?php echo set_value('min_capacity', $min_capacity); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Capacity:</b></td>
						<td><input type="text" name="max_capacity" value="<?php echo set_value('max_capacity', $max_capacity); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Status:</b></td>
						<td><select name="table_status">
							<option value="0" <?php echo set_select('table_status', '0'); ?> >Disabled</option>
						<?php if ($table_status === '1') { ?>
							<option value="1" <?php echo set_select('table_status', '1', TRUE); ?> >Enabled</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('table_status', '1'); ?> >Enabled</option>
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