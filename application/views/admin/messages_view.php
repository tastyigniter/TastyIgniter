<div class="box">
	<div id="update-box" class="content">
	<h2><?php echo $subject; ?></h2>
	<table width="100%" align="form">
		<tr>
			<td width="10%"><b>From:</b></td>
			<td><?php echo $sender; ?></td>
		</tr>
		<tr>
			<td><b>To:</b></td>
			<td><?php echo $receiver; ?></td>
		</tr>
		<tr>
			<td><b>Date:</b></td>
			<td><?php echo $date; ?></td>
		</tr>
		<tr>
			<td colspan="2"><div class="body"><?php echo $body; ?></div></td>
		</tr>
	</table>
	</div>
</div>