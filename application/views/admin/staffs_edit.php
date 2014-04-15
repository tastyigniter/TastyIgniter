<div class="box">
	<div id="update-box" class="content">
	<h2>Staff Details</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><input type="text" name="staff_name" value="<?php echo set_value('staff_name', $staff_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Email:</b></td>
    		<td><input type="text" name="staff_email" value="<?php echo set_value('staff_email', $staff_email); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Username:</b></td>
			<td><input type="text" name="username" value="<?php echo set_value('username', $username); ?>" id="username" class="textfield" /></td>
			<td></td>
		</tr>
		<tr>
    		<td><b>Staff Group:</b></td>
    		<td><select name="staff_group">
    		<option value="">- please select -</option>
			<?php foreach ($staff_groups as $staff_group) { ?>
     		<?php if ($staff_group['staff_group_id'] === $staff_group_id) { ?>
 				<option value="<?php echo $staff_group['staff_group_id']; ?>" <?php echo set_select('staff_group', $staff_group['staff_group_id'], TRUE); ?> ><?php echo $staff_group['staff_group_name']; ?></option>
			<?php } else { ?>  
 				<option value="<?php echo $staff_group['staff_group_id']; ?>" <?php echo set_select('staff_group', $staff_group['staff_group_id']); ?> ><?php echo $staff_group['staff_group_name']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><b>Location:</b></td>
    		<td><select name="staff_location">
    			<option value="">- please select -</option>
			<?php foreach ($locations as $location) { ?>
    		<?php if ($location['location_id'] === $staff_location) { ?>
  				<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
			<td><b>Password:</b><br />
			<font size="1">Leave blank to leave password unchanged</font></td>
			<td><input type="password" name="password" value="" id="password" class="textfield" autocomplete="off" /></td>
			<td></td>
		</tr>
		<tr>
			<td><b>Password Confirm:</b></td>
			<td><input type="password" name="password_confirm" id="password_confirm" class="textfield" autocomplete="off" /></td>
			<td></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="staff_status">
	   			<option value="0" <?php echo set_select('staff_status', '0'); ?> >Disabled</option>
     		<?php if ($staff_status === '1') { ?>
    			<option value="1" <?php echo set_select('staff_status', '1', TRUE); ?> >Enabled</option>
			<?php } else { ?>  
    			<option value="1" <?php echo set_select('staff_status', '1'); ?> >Enabled</option>
			<?php } ?>  
    		</select></td>
		</tr>
	</table>
	</form>
	</div>
</div>
