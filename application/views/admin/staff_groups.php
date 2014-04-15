<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Name</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($staff_groups) {?>
		<?php foreach ($staff_groups as $staff_group) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $staff_group['staff_group_id']; ?>" name="delete[]" /></td>
			<td><?php echo $staff_group['staff_group_name']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $staff_group['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else {?>
		<tr>
			<td colspan="3" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>