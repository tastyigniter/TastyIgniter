<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Status Name</th>
			<th>Status Comment</th>
			<th>Notify Customer</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($statuses) {?>
		<?php foreach ($statuses as $status) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $status['status_id']; ?>" name="delete[]" /></td>
			<td><?php echo $status['status_name']; ?></td>
			<td><?php echo $status['status_comment']; ?></td>
			<td><?php echo $status['notify_customer']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $status['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="5" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>
