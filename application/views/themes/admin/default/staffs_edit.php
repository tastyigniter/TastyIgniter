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
				<li><a class="active" rel="#staff-details">Staff Details</a></li>
				<li><a rel="#basic-settings">Basic Settings</a></li>
			</ul>
		</div>

		<div id="staff-details" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
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
						<td><input type="text" name="username" value="<?php echo set_value('username', $username); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Password:</b><br />
						<font size="1">Leave blank to leave password unchanged</font></td>
						<td><input type="password" name="password" value="" id="password" class="textfield" autocomplete="off" /></td>
					</tr>
					<tr>
						<td><b>Password Confirm:</b></td>
						<td><input type="password" name="password_confirm" id="password_confirm" class="textfield" autocomplete="off" /></td>
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
				</tbody>
			</table>
		</div>

		<div id="basic-settings" class="wrap_content" style="display:none;">
			<table class="form">
				<tbody>
					<?php if (!$staff_profile) { ?>
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
						<td><select name="staff_location_id">
							<option value="0">Use Default</option>
						<?php foreach ($locations as $location) { ?>
						<?php if ($location['location_id'] === $staff_location_id) { ?>
							<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
						<?php } else { ?>  
							<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
						<?php } ?>  
						<?php } ?>  
						</select></td>
					</tr>
					<?php } ?>  
					<tr>
						<td><b>Timezone:</b></td>
						<td><select name="timezone">
							<option value="0">Use Default</option>
						<?php foreach ($timezones as $key => $value) { ?>
						<?php if ($key === $timezone) { ?>
							<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
						<?php } else { ?>  
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
						<?php } ?>  
						<?php } ?>  
						</select></td>
					</tr>
					<tr>
						<td><b>Language:</b></td>
						<td><select name="language_id">
							<option value="0">Use Default</option>
						<?php foreach ($languages as $language) { ?>
						<?php if ($language['language_id'] === $language_id) { ?>
							<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
						<?php } else { ?>  
							<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
						<?php } ?>  
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
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 