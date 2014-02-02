<div class="box">
	<div id="update-box" class="content">
	<h2>UPDATE: <?php echo $staff_name; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
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
			<td><b>Password:</b></td>
			<td><input type="password" name="password" value="" id="password" class="textfield" /></td>
			<td></td>
		</tr>
		<tr>
			<td><b>Password Confirm:</b></td>
			<td><input type="password" name="password_confirm" id="password_confirm" class="textfield" /></td>
			<td></td>
		</tr>
		<tr>
    		<td><b>Department:</b></td>
    		<td><select name="department">
    		<option value="">- please select -</option>
			<?php foreach ($departments as $department) { ?>
     		<?php if ($department['department_id'] === $staff_department) { ?>
 				<option value="<?php echo $department['department_id']; ?>" <?php echo set_select('department', $department['department_id'], TRUE); ?> ><?php echo $department['department_name']; ?></option>
			<?php } else { ?>  
 				<option value="<?php echo $department['department_id']; ?>" <?php echo set_select('department', $department['department_id']); ?> ><?php echo $department['department_name']; ?></option>
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
