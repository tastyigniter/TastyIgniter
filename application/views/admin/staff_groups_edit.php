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
			<tr>
				<td><b>Name:</b></td>
				<td><input type="text" name="staff_group_name" value="<?php echo set_value('staff_group_name', $staff_group_name); ?>" id="staff_group_name" class="textfield" /></td>
				<td></td>
			</tr>
			</table>
		</div>

		<div id="permission-level" class="wrap_content" style="display:none;">
			<table width="500" class="list">
			<tr>
				<th>Page</th>
				<th class="center">Access</th>
				<th class="center">Modify</th>
			</tr>
			<tr>
				<th></th>
				<th class="center"><input type="checkbox" onclick="$('input[name*=\'permission[access]\']').prop('checked', this.checked);"></th>
				<th class="center"><input type="checkbox" onclick="$('input[name*=\'permission[modify]\']').prop('checked', this.checked);"></th>
			</tr>
			<?php foreach ($paths as $key => $value) { ?>
			<tr>
				<td><?php echo $value; ?></td>
				<?php if (in_array($value, $access)) { ?>
					<td width="10" class="center"><input type="checkbox" name="permission[access][]" value="<?php echo $value; ?>" checked="checked" /></td>
				<?php } else { ?>
					<td width="10" class="center"><input type="checkbox" name="permission[access][]" value="<?php echo $value; ?>" /></td>
				<?php } ?>

				<?php if (in_array($value, $modify)) { ?>
					<td width="10" class="center"><input type="checkbox" name="permission[modify][]" value="<?php echo $value; ?>" checked="checked" /></td>
				<?php } else { ?>
					<td width="10" class="center"><input type="checkbox" name="permission[modify][]" value="<?php echo $value; ?>" /></td>
				<?php } ?>
			</tr>
			<?php } ?>
			</table>
		</div>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 