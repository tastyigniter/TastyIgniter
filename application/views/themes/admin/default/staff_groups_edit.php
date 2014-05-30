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
				<li><a class="active" rel="#staff-group">Staff Group</a></li>
				<li><a rel="#permission-level">Permission Levels</a></li>
			</ul>
		</div>

		<div id="staff-group" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="staff_group_name" value="<?php echo set_value('staff_group_name', $staff_group_name); ?>" id="staff_group_name" class="textfield" /></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Location Access:</b></td>
						<td><select name="location_access">
							<option value="0" <?php echo set_select('location_access', '0'); ?> >All Locations</option>
						<?php if ($location_access === '1') { ?>
							<option value="1" <?php echo set_select('location_access', '1', TRUE); ?> >Staff Location</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('location_access', '1'); ?> >Staff Location</option>
						<?php } ?>  
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="permission-level" class="wrap_content" style="display:none;">
			<table width="500" class="list">
				<thead>
					<tr>
						<th class="action action-one">Access</th>
						<th class="action action-one">Modify</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'permission[access]\']').prop('checked', this.checked);"></th>
						<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'permission[modify]\']').prop('checked', this.checked);"></th>
						<th>Select/Unselect All</th>
						<th></th>
						<th></th>
					</tr>
					<?php foreach ($paths as $path) { ?>
					<tr>
						<?php if (in_array($path['name'], $access)) { ?>
							<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $path['name']; ?>" checked="checked" /></td>
						<?php } else { ?>
							<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $path['name']; ?>" /></td>
						<?php } ?>

						<?php if (in_array($path['name'], $modify)) { ?>
							<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $path['name']; ?>" checked="checked" /></td>
						<?php } else { ?>
							<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $path['name']; ?>" /></td>
						<?php } ?>
						<td><?php echo $path['name']; ?></td>
						<td><?php echo $path['description']; ?></td>
						<td></td>
					</tr>
					<?php } ?>
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