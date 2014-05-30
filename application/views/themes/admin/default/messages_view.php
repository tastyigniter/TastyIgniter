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
	<div id="update-box" class="content view-message">
	<form id="message-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<div class="wrap_content">
			<table width="100%" class="form">
				<tbody>
					<tr>
						<td width="10%"><b>Send Type:</b></td>
						<td><?php echo $send_type; ?></td>
					</tr>
					<tr>
						<td><b>From:</b></td>
						<td><?php echo $from; ?></td>
					</tr>
					<tr>
						<td><b>To:</b></td>
						<td><a class="recipient"><?php echo $recipient; ?></a></td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td><b>Date:</b></td>
						<td><?php echo $date_added; ?></td>
					</tr>
					<tr>
						<td colspan="2"><h2><?php echo $subject; ?></h2></td>
					</tr>
					<tr>
						<td colspan="2"><div class="body"><?php echo $body; ?></div></td>
					</tr>
				</tbody>
			</table>
		</div>

		<?php if ($label === 'all') { ?>
		<div id="recipients" class="wrap_content" style="display:none">
			<h2>Recipients List</h2>
			<table class="list">
				<?php if ($recipients) { ?>
				<thead>
					<tr>
						<?php if ($send_type === 'Email') { ?>
							<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
							<th>Email</th>
							<th>Status</th>
							<th class="id">ID</th>
						<?php } ?>
						<?php if ($send_type === 'Account') { ?>
							<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
							<th>Recipient</th>
							<th>Status</th>
							<th class="id">ID</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($recipients as $recipient) { ?>
					<tr>
						<?php if ($send_type === 'Email') { ?>
							<td class="action action-one"><input type="checkbox" value="<?php echo $recipient['message_recipient_id']; ?>" name="delete[]" /></td>
							<td><?php echo $recipient['recipient_email']; ?></td>
							<td><?php echo $recipient['status']; ?></td>
							<td class="id"><?php echo $recipient['message_recipient_id']; ?></td>
						<?php } ?>
						<?php if ($send_type === 'Account') { ?>
							<td class="action action-one"><input type="checkbox" value="<?php echo $recipient['message_recipient_id']; ?>" name="delete[]" /></td>
							<td><?php echo $recipient['recipient_name']; ?></td>
							<td><?php echo $recipient['status']; ?></td>
							<td class="id"><?php echo $recipient['message_recipient_id']; ?></td>
						<?php } ?>
					</tr>
					<?php } ?>
				</tbody>
				<?php } else { ?>
				<tbody>
					<tr>
						<td align="center"><?php echo $text_empty; ?></td>
					</tr>
				</tbody>
				<?php } ?>
			</table>
		</div>
		<?php } ?>
	</form>
	</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  	$('.recipient').on('click', function() {
  		if ($('#recipients').is(':visible')) {
     		$('#recipients').fadeOut();
   			$('.recipient').attr('class', '');
		} else {
   			$('#recipients').fadeIn();
   			$('.recipient').attr('class', 'active');
		}
	});	
});	
</script>
<script type="text/javascript">
function markAsUnread() {
	$('#message-form').append('<input type="hidden" name="message_state" value="unread" />');
	$('#message-form').submit();
}

function moveToInbox() {
	$('#message-form').append('<input type="hidden" name="message_state" value="inbox" />');
	$('#message-form').submit();
}

function moveToTrash() {
	if (confirm('Are you sure you want to do this?')) {
		$('#message-form').append('<input type="hidden" name="message_state" value="trash" />');
		$('#message-form').submit();
	} else {
		return false;
	}
}
</script>