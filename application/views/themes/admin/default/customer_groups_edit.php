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
				<li><a rel="#customer-group" class="active">Customer Group Details</a></li>
			</ul>
		</div>

		<div id="customer-group" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="group_name" value="<?php echo set_value('group_name', $group_name); ?>" /></td>
					</tr>
					<tr>
						<td><b>Approval:</b><br />
						<font size="1">New customers must be approved before they can login.</font></td>
						<td><select name="approval">
							<option value="0" <?php echo set_select('approval', '0'); ?> >Disabled</option>
						<?php if ($approval === '1') { ?>
							<option value="1" <?php echo set_select('approval', '1', TRUE); ?> >Enabled</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('approval', '1'); ?> >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
					<tr>
						<td><b>Description:</b></td>
						<td><textarea name="description" rows="5" cols="45"><?php echo set_value('description', $description); ?></textarea></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
	</div>
</div>