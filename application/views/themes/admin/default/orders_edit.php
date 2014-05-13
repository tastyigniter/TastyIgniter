<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">Order</a></li>
				<li><a rel="#status">Status</a></li>
				<li><a rel="#restaurant">Restaurant</a></li>
				<?php if ($check_order_type === '1') { ?>
					<li><a rel="#delivery-address">Delivery Address</a></li>
				<?php } ?>
				<li><a rel="#payment">Payment</a></li>
				<li><a rel="#menus">Menus (<?php echo $total_items; ?>)</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Order ID:</b></td>
						<td>#<?php echo $order_id; ?></td>
					</tr>
					<tr>
						<td><b>Name:</b></td>
						<td><a href="<?php echo $customer_edit; ?>"><?php echo $first_name; ?> <?php echo $last_name; ?></a></td>
					</tr>
					<tr>
						<td><b>Email:</b></td>
						<td><?php echo $email; ?></td>
					</tr>
					<tr>
						<td><b>Telephone:</b></td>
						<td><?php echo $telephone; ?></td>
					</tr>
					<tr>
						<td><b>Order Type:</b></td>
						<td><?php echo $order_type; ?></td>
					</tr>    	
					<tr>
						<td><b>Delivery/Collection Time:</b></td>
						<td><?php echo $order_time; ?></td>
					</tr>    	
					<tr>
						<td><b>Order Date:</b></td>
						<td><?php echo $date_added; ?></td>
					</tr>    	
					<tr>
						<td><b>Total:</b></td>
						<td><?php echo $order_total; ?></td>
					</tr>    	
					<tr>
						<td><b>Comment:</b></td>
						<td><?php echo $comment; ?></td>
					</tr>
					<tr>
						<td><b>Date Modified:</b></td>
						<td><?php echo $date_modified; ?></td>
					</tr>    	
					<tr>
						<td><b>Notified Customer:</b></td>
						<td>
						<?php if ($notify === '1') { ?>
							Email SENT
						<?php } else { ?>
							Email not SENT
						<?php } ?>
						</td>
					</tr>
					<tr>
						<td><b>IP Address:</b></td>
						<td><?php echo $ip_address; ?></td>
					</tr>    	
					<tr>
						<td><b>User Agent:</b></td>
						<td><?php echo $user_agent; ?></td>
					</tr>    	
				</tbody>
			</table>
		</div>

		<div id="status" class="wrap_content" style="display:none;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Order Status:</b></td>
						<td><select name="order_status" onChange="getStatusComment();">
						<?php foreach ($statuses as $status) { ?>
						<?php if ($status['status_id'] === $status_id) { ?>
							<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('order_status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('order_status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select></td>
					</tr>    	
					<tr>
						<td><b>Status Comment:</b></td>
						<td><textarea name="status_comment" rows="5" cols="45"><?php echo set_value('status_comment'); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Notify Customer:</b></td>
						<td><input type="checkbox" name="notify" value="1" /></td>
					</tr>
				</tbody>
			</table>
			<br /><br />
			
			<h2>History</h2>
			<table height="auto" class="list" id="history">
				<thead>
					<tr>
						<th>Date/Time</th>
						<th>Status</th>
						<th>Staff</th>
						<th class="center">Customer Notified</th>
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
						<td class="center"><?php echo ($history['notify'] === '1') ? 'Yes' : 'No'; ?></td>
						<td class="left"><?php echo $history['comment']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="5" align="center"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

		<div id="restaurant" class="wrap_content" style="display:none;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Name:</b></td>
						<td><?php echo $location_name; ?></td>
					</tr>
					<tr>
						<td><b>Address:</b></td>
						<td><address><?php echo $location_address; ?></address></td>
					</tr>
				</tbody>
			</table>
		</div>

		<?php if ($check_order_type === '1') { ?>
		<div id="delivery-address" class="wrap_content" style="display:none;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Address:</b></td>
						<td><address><?php echo $customer_address; ?></address></td>
					</tr>    	
				</tbody>
			</table>
		</div>
		<?php } ?>

		<div id="payment" class="wrap_content" style="display:none;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Payment Method:</b></td>
						<td><?php echo $payment; ?>
						<?php if ($paypal_details) { ?>
							<a class="view_details">View Transaction Details</a><br />
						<?php } ?>
						</td>
					</tr>    	
				</tbody>
			</table>
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

		<div id="menus" class="wrap_content" style="display:none;">
			<table height="auto" class="list">
				<thead>
					<tr>
						<th width="1"></th>
						<th class="food_name" width="25%">Name/Options</th>
						<th class="center">Price</th>
						<th width="25%">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($cart_items as $cart_item) { ?>
					<tr id="<?php echo $cart_item['id']; ?>">
						<td width="1"><?php echo $cart_item['qty']; ?>x</td>
						<td class="food_name"><?php echo $cart_item['name']; ?><br />
						<?php if (!empty($cart_item['options'])) { ?>
							<div><font size="1">+ <?php echo $cart_item['options']['name']; ?>: <?php echo $cart_item['options']['price']; ?> </font></div>
						<?php } ?>
						</td>
						<td class="center"><?php echo $cart_item['price']; ?></td>
						<td><?php echo $cart_item['subtotal']; ?></td>
					</tr>
					<?php } ?>
					<?php foreach ($totals as $total) { ?>
					<tr>
						<td width="1"></td>
						<td></td>
						<td class="center"><b><?php echo $total['title']; ?></b></td>
						<td><b><?php echo $total['value']; ?></b></td>
					</tr>    	
					<?php } ?>
					<tr>
						<td width="1"></td>
						<td></td>
						<td class="center"><b>TOTAL</b></td>
						<td><b><?php echo $order_total; ?></b></td>
					</tr>    	
				</tbody>
			</table>
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

$('#tabs a').tabs();
</script>
<script type="text/javascript"><!--
function getStatusComment() {
	if ($('select[name="order_status"]').val()) {
		$.ajax({
			url: js_site_url('admin/order_statuses/comment?status_id=') + encodeURIComponent($('select[name="order_status"]').val()),
			dataType: 'json',
			success: function(json) {
				$('textarea[name="status_comment"]').html(json);
			}
		});
	}
};

$('select[name="order_status"]').trigger('change');
//--></script>