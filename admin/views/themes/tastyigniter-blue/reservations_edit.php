<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Reservation</a></li>
				<li><a href="#status" data-toggle="tab">Status & Assign</a></li>
				<li><a href="#table" data-toggle="tab">Table</a></li>
				<li><a href="#restaurant" data-toggle="tab">Restaurant</a></li>
				<li><a href="#customer" data-toggle="tab">Customer</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Reservation ID:</label>
						<div class="col-sm-5">
							#<?php echo $reservation_id; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Guest Number:</label>
						<div class="col-sm-5">
							<?php echo $guest_num; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Reservation Date:</label>
						<div class="col-sm-5">
							<?php echo $reserve_date; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Reservation Time:</label>
						<div class="col-sm-5">
							<?php echo $reserve_time; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Occasion:</label>
						<div class="col-sm-5">
							<?php echo $occasions[$occasion]; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Date Added:</label>
						<div class="col-sm-5">
							<?php echo $date_added; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Date Modified:</label>
						<div class="col-sm-5">
							<?php echo $date_modified; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Notify Customer:</label>
						<div class="col-sm-5">
							<?php if ($notify === '1') { ?>
								Reservation Confirmation Email SENT
							<?php } else { ?>
								Reservation Confirmation Email not SENT
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Customer IP:</label>
						<div class="col-sm-5">
							<?php echo $ip_address; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Customer User Agent:</label>
						<div class="col-sm-5">
							<?php echo $user_agent; ?>
						</div>
					</div>
				</div>

				<div id="status" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-assign-staff" class="col-sm-3 control-label">Assign Staff:</label>
						<div class="col-sm-5">
							<select name="assignee_id" class="form-control">
								<option value=""> - please select - </option>
								<?php foreach ($staffs as $staff) { ?>
									<?php if ($staff['staff_id'] === $assignee_id) { ?>
										<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assignee_id', $staff['staff_id'], TRUE); ?> ><?php echo $staff['staff_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assignee_id', $staff['staff_id']); ?> ><?php echo $staff['staff_name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('assignee_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Reservation Status:</label>
						<div class="col-sm-5">
							<select name="status" class="form-control" onChange="getStatusComment();">
							<?php foreach ($statuses as $status) { ?>
								<?php if ($status['status_id'] === $status_id) { ?>
									<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
								<?php } ?>
							<?php } ?>
							</select>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-comment" class="col-sm-3 control-label">Status Comment:</label>
						<div class="col-sm-5">
							<textarea name="status_comment" rows="5" class="form-control"><?php echo set_value('status_comment'); ?></textarea>
							<?php echo form_error('status_comment', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-notify" class="col-sm-3 control-label">Notify Customer:</label>
						<div class="col-sm-5">
							<div id="input-notify" class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($notify == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="notify" value="0" <?php echo set_radio('notify', '0'); ?>>NO</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="notify" value="1" <?php echo set_radio('notify', '1', TRUE); ?>>YES</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="notify" value="0" <?php echo set_radio('notify', '0', TRUE); ?>>NO</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="notify" value="1" <?php echo set_radio('notify', '1'); ?>>YES</label>
								<?php } ?>
							</div>
							<?php echo form_error('notify', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<br />

					<h3>History</h3>
					<table height="auto" class="table table-striped table-border" id="history">
						<thead>
							<tr>
								<th width="15%">Date/Time</th>
								<th>Status</th>
								<th>Staff</th>
								<th>Staff Assignee</th>
								<th class="text-center">Customer Notified</th>
								<th class="left" width="35%">Comment</th>
							</tr>
						</thead>
						<tbody>
							<?php if ($status_history) { ?>
							<?php foreach ($status_history as $history) { ?>
							<tr>
								<td><?php echo $history['date_time']; ?></td>
								<td><?php echo $history['status_name']; ?></td>
								<td><?php echo $history['staff_name']; ?></td>
								<td>
								<?php foreach ($staffs as $staff) { ?>
									<?php if ($staff['staff_id'] === $history['assignee_id']) { ?>
										<?php echo $staff['staff_name']; ?>
									<?php } ?>
								<?php } ?>
								</td>
								<td class="text-center"><?php echo ($history['notify'] === '1') ? 'Yes' : 'No'; ?></td>
								<td class="left"><?php echo $history['comment']; ?></td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td colspan="6"><?php echo $text_empty; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

				<div id="table" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Table Name:</label>
						<div class="col-sm-5">
							<?php echo $table_name; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Table Minimum:</label>
						<div class="col-sm-5">
							<?php echo $min_capacity; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Table Capacity:</label>
						<div class="col-sm-5">
							<?php echo $max_capacity; ?>
						</div>
					</div>
				</div>

				<div id="restaurant" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Restaurant Name:</label>
						<div class="col-sm-5">
							<?php echo $location_name; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Restaurant Address:</label>
						<div class="col-sm-5">
							<address>
								<?php echo $location_address_1; ?>,
								<?php echo $location_city; ?>,
								<?php echo $location_postcode; ?>,
								<?php echo $location_country; ?>
							</address>
						</div>
					</div>
				</div>

				<div id="customer" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Customer Name:</label>
						<div class="col-sm-5">
							<?php echo $first_name; ?> <?php echo $last_name; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Customer Email:</label>
						<div class="col-sm-5">
							<?php echo $email; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Customer Telephone:</label>
						<div class="col-sm-5">
							<?php echo $telephone; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Comment:</label>
						<div class="col-sm-5">
							<?php echo $comment; ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  	$('.view_details').on('click', function(){
  		if($('.paypal_details').is(':visible')){
     		$('.paypal_details').fadeOut();
   			$('.view_details').attr('class', '');
		} else {
   			$('.paypal_details').fadeIn();
   			$('.view_details').attr('class', 'active');
		}
	});
});
</script>
<script type="text/javascript"><!--
function getStatusComment() {
	if ($('select[name="status"]').val()) {
		$.ajax({
			url: js_site_url('statuses/comment?status_id=') + encodeURIComponent($('select[name="status"]').val()),
			dataType: 'json',
			success: function(json) {
				$('textarea[name="status_comment"]').html(json);
			}
		});
	}
};

$('select[name="status"]').trigger('change');
//--></script>
<?php echo get_footer(); ?>