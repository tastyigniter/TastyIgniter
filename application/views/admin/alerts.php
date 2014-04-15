<div class="box">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Subject</th>
			<th>Sender</th>
			<th class="right">Date</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($alerts) {?>
		<?php foreach ($alerts as $alert) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="Delete" name="delete[<?php echo $alert['message_id']; ?>]" /></td>
			<td><?php echo $alert['subject']; ?><br /><font size="1"><?php echo $alert['body']; ?></font></td>
			<td><?php echo $alert['sender']; ?></td>
			<td class="right"><?php echo $alert['date']; ?></td>
			<td class="right"><a class="view" title="View" href="<?php echo $alert['view']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="6" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>

	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
</div>