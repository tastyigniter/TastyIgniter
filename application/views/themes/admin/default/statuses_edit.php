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
						<td><b>Name:</b></td>
						<td><input type="text" name="status_name" value="<?php echo set_value('status_name', $status_name); ?>" id="name" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Status For:</b></td>
						<td><select name="status_for">
						<?php if ($status_for === 'order') { ?>
							<option value="order" <?php echo set_select('status_for', 'order', TRUE); ?> >Order</option>
							<option value="reserve" <?php echo set_select('status_for', 'reserve'); ?> >Reservation</option>
						<?php } else if ($status_for === 'reserve') { ?>  
							<option value="order" <?php echo set_select('status_for', 'order'); ?> >Order</option>
							<option value="reserve" <?php echo set_select('status_for', 'reserve', TRUE); ?> >Reservation</option>
						<?php } else { ?>  
							<option value="order" <?php echo set_select('status_for', 'order'); ?> >Order</option>
							<option value="reserve" <?php echo set_select('status_for', 'reserve'); ?> >Reservation</option>
						<?php } ?>  
						</select></td>
					</tr>
					<tr>
						<td><b>Comment:</b></td>
						<td><textarea name="status_comment" cols="50" rows="7"><?php echo set_value('status_comment', $status_comment); ?> </textarea></td>
					</tr>
					<tr>
						<td><b>Notify Customer:</b></td>
						<td><?php if ($notify_customer === '1') { ?>
								<input type="checkbox" name="notify_customer" value="<?php echo $notify_customer; ?>" checked="checked" />
							<?php } else { ?>
								<input type="checkbox" name="notify_customer" value="1" />
							<?php } ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
	</div>
</div>