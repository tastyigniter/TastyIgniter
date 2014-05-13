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
				</tbody>
			</table>
		</div>

		<div id="permission-level" class="wrap_content" style="display:none;">
			<table width="500" class="list">
				<thead>
					<tr>
						<th class="action action-one">Access</th>
						<th class="action action-one">Modify</th>
						<th>Page</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'permission[access]\']').prop('checked', this.checked);"></th>
						<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'permission[modify]\']').prop('checked', this.checked);"></th>
						<th></th>
						<th></th>
					</tr>
					<?php foreach ($paths as $key => $value) { ?>
					<tr>
						<?php if (in_array($value, $access)) { ?>
							<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $value; ?>" checked="checked" /></td>
						<?php } else { ?>
							<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $value; ?>" /></td>
						<?php } ?>

						<?php if (in_array($value, $modify)) { ?>
							<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $value; ?>" checked="checked" /></td>
						<?php } else { ?>
							<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $value; ?>" /></td>
						<?php } ?>
						<td><?php echo $value; ?></td>
						<td></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 