<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
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
			<td colspan="8" align="center"><?php echo $text_empty; ?></td>
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
