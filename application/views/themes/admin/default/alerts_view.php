<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="update-box" class="content">
	<h2><?php echo $subject; ?></h2>
	<table width="100%" class="form">
		<tbody>
			<tr>
				<td width="10%"><b>From:</b></td>
				<td><?php echo $sender; ?></td>
			</tr>
			<tr>
				<td><b>To:</b></td>
				<td><?php echo $recipient; ?></td>
			</tr>
			<tr>
				<td><b>Date:</b></td>
				<td><?php echo $date; ?></td>
			</tr>
			<tr>
				<td colspan="2"><div class="body"><?php echo $body; ?></div></td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
</div>