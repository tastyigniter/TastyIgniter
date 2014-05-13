<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<table class="list list-height">
			<thead>
				<tr>
					<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th>Name</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($staff_groups) {?>
				<?php foreach ($staff_groups as $staff_group) { ?>
				<tr>
					<td class="action"><input type="checkbox" value="<?php echo $staff_group['staff_group_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
						<a class="edit" title="Edit" href="<?php echo $staff_group['edit']; ?>"></a></td>
					<td><?php echo $staff_group['staff_group_name']; ?></td>
					<td></td>
				</tr>
				<?php } ?>
				<?php } else {?>
				<tr>
					<td colspan="3" align="center"><?php echo $text_empty; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</form>
	</div>
</div>