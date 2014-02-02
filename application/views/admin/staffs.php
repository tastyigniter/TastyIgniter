<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD NEW STAFF</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><input type="text" name="staff_name" value="<?php echo set_value('staff_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Email:</b></td>
    		<td><input type="text" name="staff_email" value="<?php echo set_value('staff_email'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Username</b></td>
			<td><input type="text" name="username" value="<?php echo set_value('username'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Password</b></td>
			<td><input type="password" name="password" value="<?php echo set_value('password'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Password Confirm</b></td>
			<td><input type="password" name="password_confirm" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Department:</b></td>
    		<td><select name="department">
    		<option value="">- please select -</option>
 			<?php foreach ($departments as $department) { ?>
 				<option value="<?php echo $department['department_id']; ?>" <?php echo set_select('department', $department['department_id']); ?> ><?php echo $department['department_name']; ?></option>
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><b>Location:</b></td>
    		<td><select name="staff_location">
    			<option value="">- please select -</option>
			<?php foreach ($locations as $location) { ?>
  				<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="staff_status">
    			<option value="0" <?php echo set_select('staff_status', '0'); ?> >Disabled</option>
    			<option value="1" <?php echo set_select('staff_status', '1'); ?> >Enabled</option>
    		</select></td>
		</tr>
	</table>
	</form>
  	</div>
  	
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table border="0" align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Location</th>
			<th>Name</th>
			<th>Email</th>
			<th>Department</th>
			<th>Status</th>
			<th class="right">Date Added</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($staffs) { ?>
		<?php foreach ($staffs as $staff) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $staff['staff_id']; ?>" name="delete[]" /></td>
			<td><?php echo $staff['staff_location']; ?></td>
			<td><?php echo $staff['staff_name']; ?></td>
			<td><?php echo $staff['staff_email']; ?></td>
			<td><?php echo $staff['staff_department']; ?></td>
			<td><?php echo ($staff['staff_status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
			<td class="right"><?php echo $staff['date_added']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $staff['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else {?>
		<tr>
			<td colspan="9" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>

	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
	</div>
</div>
