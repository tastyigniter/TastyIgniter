<div class="content">
	<div class="wrap">
	<table width="100%" align="center">
		<tr>
			<td width="20%"><b><?php echo $column_date; ?>:</b></td>
			<td><?php echo $date; ?></td>
		</tr>
		<tr>
			<td><b><?php echo $column_time; ?>:</b></td>
			<td><?php echo $time; ?></td>
		</tr>
		<tr>
			<td><b><?php echo $column_subject; ?>:</b></td>
			<td><?php echo $subject; ?></td>
		</tr>
	</table>

	<div class="separator"></div>
	<table width="100%" align="center">
		<tr>
			<td colspan="2"><div class="msg_body"><?php echo $body; ?></div></td>
		</tr>
	</table>
	</div>

	<div class="separator"></div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
	</div>
</div>