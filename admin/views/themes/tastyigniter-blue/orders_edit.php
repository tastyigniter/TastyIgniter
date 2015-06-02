<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Order</a></li>
				<li><a href="#status" data-toggle="tab">Status</a></li>
				<li><a href="#restaurant" data-toggle="tab">Restaurant</a></li>
				<?php if ($check_order_type === '1') { ?>
					<li><a href="#delivery-address" data-toggle="tab">Delivery Address</a></li>
				<?php } ?>
				<li><a href="#payment" data-toggle="tab">Payment</a></li>
				<li><a href="#menus" data-toggle="tab">Menus &nbsp;<span class="badge"><?php echo $total_items; ?></span></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Order ID:</label>
						<div class="col-sm-5">
							#<?php echo $order_id; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Name:</label>
						<div class="col-sm-5">
							<?php if (!empty($customer_id)) { ?>
								<a href="<?php echo $customer_edit; ?>"><?php echo $first_name; ?> <?php echo $last_name; ?></a>
							<?php } else { ?>
								<?php echo $first_name; ?> <?php echo $last_name; ?> <span class="badge">Guest Order</span>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Email:</label>
						<div class="col-sm-5">
							<?php echo $email; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Telephone:</label>
						<div class="col-sm-5">
							<?php echo $telephone; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Order Type:</label>
						<div class="col-sm-5">
							<?php echo $order_type; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Delivery/Collection Time:</label>
						<div class="col-sm-5">
							<?php echo $order_time; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Order Date:</label>
						<div class="col-sm-5">
							<?php echo $date_added; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Total:</label>
						<div class="col-sm-5">
							<?php echo $order_total; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Comment:</label>
						<div class="col-sm-5">
							<?php echo $comment; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Date Modified:</label>
						<div class="col-sm-5">
							<?php echo $date_modified; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Notified Customer:</label>
						<div class="col-sm-5">
							<?php if ($notify === '1') { ?>
								Email SENT
							<?php } else { ?>
								Email not SENT
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">IP Address:</label>
						<div class="col-sm-5">
							<?php echo $ip_address; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">User Agent:</label>
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
						<label for="input-name" class="col-sm-3 control-label">Order Status:</label>
						<div class="col-sm-5">
							<select name="order_status" id="" class="form-control" onChange="getStatusComment();">
							<?php foreach ($statuses as $status) { ?>
							<?php if ($status['status_id'] === $status_id) { ?>
								<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('order_status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('order_status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
							<?php } ?>
							<?php } ?>
							</select>
							<?php echo form_error('order_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Status Comment:</label>
						<div class="col-sm-5">
							<textarea name="status_comment" id="" class="form-control" rows="5" cols="45"><?php echo set_value('status_comment'); ?></textarea>
							<?php echo form_error('status_comment', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Notify Customer:</label>
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
					<div class="panel panel-default panel-table">
						<div class="table-responsive">
							<table height="auto" class="table table-striped table-border" id="history">
								<thead>
									<tr>
										<th>Date/Time</th>
										<th>Status</th>
										<th>Staff</th>
										<th>Staff Assignee</th>
										<th class="text-center">Customer Notified</th>
										<th class="left" width="25%">Comment</th>
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
										<td colspan="5"><?php echo $text_empty; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div id="restaurant" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Name:</label>
						<div class="col-sm-5">
							<?php echo $location_name; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Address:</label>
						<div class="col-sm-5">
							<address><?php echo $location_address; ?></address>
						</div>
					</div>
				</div>

				<?php if ($check_order_type === '1') { ?>
				<div id="delivery-address" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Address:</label>
						<div class="col-sm-5">
							<address><?php echo $customer_address; ?></address>
						</div>
					</div>
				</div>
				<?php } ?>

				<div id="payment" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Payment Method:</label>
						<div class="col-sm-5">
							<?php echo $payment; ?>
							<?php if ($paypal_details) { ?>
								<a class="view_details">View Transaction Details</a><br />
							<?php } ?>
						</div>
					</div>
					<div class="paypal_details" style="display:none">
						<ul>
						<?php foreach ($paypal_details as $key => $value) { ?>
							<li>
								<span><?php echo $key; ?></span> <?php echo $value; ?>
							</li>
						<?php } ?>
						</ul>
					</div>
				</div>

				<div id="menus" class="tab-pane row wrap-all">
					<div class="panel panel-default panel-table">
						<div class="table-responsive">
							<table height="auto" class="table table-striped table-border">
								<thead>
									<tr>
										<th></th>
										<th width="25%">Name/Options</th>
										<th class="text-center">Price</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($cart_items as $cart_item) { ?>
									<tr id="<?php echo $cart_item['id']; ?>">
										<td><?php echo $cart_item['qty']; ?>x</td>
										<td><?php echo $cart_item['name']; ?><br />
										<?php if (!empty($cart_item['options'])) { ?>
											<div><font size="1">+ <?php echo $cart_item['options']; ?></font></div>
										<?php } ?>
										</td>
										<td class="text-center"><?php echo $cart_item['price']; ?></td>
										<td><?php echo $cart_item['subtotal']; ?></td>
									</tr>
									<?php } ?>
									<?php foreach ($totals as $total) { ?>
									<tr>
										<td width="1"></td>
										<td></td>
										<td class="text-center"><b><?php echo $total['title']; ?></b></td>
										<td><b><?php echo $total['value']; ?></b></td>
									</tr>
									<?php } ?>
									<tr>
										<td width="1"></td>
										<td></td>
										<td class="text-center"><b>TOTAL</b></td>
										<td><b><?php echo $order_total; ?></b></td>
									</tr>
								</tbody>
							</table>
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
	if ($('select[name="order_status"]').val()) {
		$.ajax({
			url: js_site_url('statuses/comment?status_id=') + encodeURIComponent($('select[name="order_status"]').val()),
			dataType: 'json',
			success: function(json) {
				$('textarea[name="status_comment"]').html(json);
			}
		});
	}
};

$('select[name="order_status"]').trigger('change');
//--></script>
<?php echo get_footer(); ?>