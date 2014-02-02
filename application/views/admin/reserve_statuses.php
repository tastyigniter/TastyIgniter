<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD A NEW STATUS</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
			<td><b>Name</b></td>
			<td><input type="text" name="status_name" value="<?php echo set_value('status_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Comment</b></td>
			<td><textarea name="status_comment" cols="50" rows="7"><?php echo set_value('status_comment'); ?></textarea></td>
		</tr>
		<tr>
			<td><b>Notify Customer:</b></td>
			<td><input type="checkbox" name="notify_customer" value="1" <?php echo set_checkbox('notify_customer', '1'); ?> /></td>
		</tr>
  	</table>
	</form>
	</div>
	
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
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
			<td colspan="5"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>
