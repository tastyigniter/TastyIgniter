<?php echo $header; ?>
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>
<div class="row content">
	<div class="col-md-12">
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
<?php echo $footer; ?>