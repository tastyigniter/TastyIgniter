<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
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

		<form role="form" id="message-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<div class="row wrap-all">
				<table width="100%" class="table">
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
						<tr>
							<td><b>Date:</b></td>
							<td><?php echo $date_added; ?></td>
						</tr>
						<tr>
							<td colspan="2" class="border-bottom"><h4><?php echo $subject; ?></h4></td>
						</tr>
					</tbody>
				</table>

				<div class="body"><?php echo $body; ?></div>
			</div>
		</form>
		
		<?php if ($label === 'all') { ?>
		<div id="recipients" class="tab-pane row wrap-all" style="display:none">
			<h3>Recipients List</h3>
			<table class="table table-striped table-border">
				<?php if ($recipients) { ?>
				<thead>
					<tr>
						<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th><?php echo ($send_type === 'Email') ? 'Email' : 'Recipient'; ?></th>
						<th class="text-center">Status</th>
						<th class="id">ID</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($recipients as $recipient) { ?>
					<tr>
						<?php if ($send_type === 'Email') { ?>
							<td class="action action-one"><input type="checkbox" value="<?php echo $recipient['message_recipient_id']; ?>" name="delete[]" /></td>
							<td><?php echo $recipient['recipient_email']; ?></td>
							<td class="text-center"><?php echo $recipient['status']; ?></td>
							<td class="id"><?php echo $recipient['message_recipient_id']; ?></td>
						<?php } ?>
						<?php if ($send_type === 'Account') { ?>
							<td class="action action-one"><input type="checkbox" value="<?php echo $recipient['message_recipient_id']; ?>" name="delete[]" /></td>
							<td><?php echo $recipient['recipient_name']; ?></td>
							<td class="text-center"><?php echo $recipient['status']; ?></td>
							<td class="id"><?php echo $recipient['message_recipient_id']; ?></td>
						<?php } ?>
					</tr>
					<?php } ?>
				</tbody>
				<?php } else { ?>
				<tbody>
					<tr>
						<td><?php echo $text_empty; ?></td>
					</tr>
				</tbody>
				<?php } ?>
			</table>
		</div>
		<?php } ?>
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
<?php echo $footer; ?>