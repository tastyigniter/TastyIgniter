<div class="content">
<div class="img_inner">
	<h3><?php echo $text_heading; ?></h3>
</div>  
<div class="img_inner">
	<table width="100%" class="list">
		<tr>
			<th align="left"><?php echo $column_subject; ?></th>
			<th align="center"><?php echo $column_date; ?></th>
			<th align="right"><?php echo $column_action; ?></th>
		</tr>
		<?php if ($messages) {?>
		<?php foreach ($messages as $message) { ?>
		<tr>
			<td align="left"><?php echo $message['subject']; ?><br /><font size="1"><?php echo $message['body']; ?></font></td>
			<td align="center"><?php echo $message['date']; ?></td>
			<td align="right"><a class="edit" href="<?php echo $message['edit']; ?>"><?php echo $text_view; ?></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="8" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
</div>

	<div class="separator"></div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
	</div>
</div>