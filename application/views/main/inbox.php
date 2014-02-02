<div class="content">
	<div class="wrap">
	<table width="100%" align="center" class="list">
		<tr>
			<th><?php echo $column_date; ?></th>
			<th><?php echo $column_time; ?></th>
			<th><?php echo $column_subject; ?></th>
			<th><?php echo $column_action; ?></th>
		</tr>
		<?php if ($messages) {?>
		<?php foreach ($messages as $message) { ?>
		<tr align="center">
			<td><?php echo $message['date']; ?></td>
			<td><?php echo $message['time']; ?></td>
			<td><?php echo $message['subject']; ?><br /><font size="1"><?php echo $message['body']; ?></font></td>
			<td><a class="edit" href="<?php echo $message['edit']; ?>"><?php echo $text_view; ?></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="8" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
	</div>
</div>