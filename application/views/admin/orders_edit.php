<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">Order</a></li>
				<li><a rel="#status">Status & Assign</a></li>
				<li><a rel="#restaurant">Restaurant</a></li>
				<li><a rel="#customer">Customer</a></li>
				<li><a rel="#payment">Payment</a></li>
				<li><a rel="#menus">Menus (<?php echo $total_items; ?>)</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tr>
					<td><b>Order ID:</b></td>
					<td>#<?php echo $order_id; ?></td>
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
					<td><b>Total:</b></td>
					<td><?php echo $order_total; ?></td>
				</tr>    	
				<tr>
					<td><b>Date Added:</b></td>
					<td><?php echo $date_added; ?></td>
				</tr>    	
				<tr>
					<td><b>Date Modified:</b></td>
					<td><?php echo $date_modified; ?></td>
				</tr>    	
				<tr>
					<td><b>Notify Customer:</b></td>
					<td>
					<?php if ($notify === '1') { ?>
						Order Confirmation Email SENT
					<?php } else { ?>
						Order Confirmation Email not SENT
					<?php } ?>
				</tr>
				<tr>
					<td><b>IP Address:</b></td>
					<td><?php echo $ip_address; ?></td>
				</tr>    	
				<tr>
					<td><b>User Agent:</b></td>
					<td><?php echo $user_agent; ?></td>
				</tr>    	
			</table>
		</div>

		<div id="status" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Order Status:</b></td>
					<td><select name="order_status">
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
					<td><b>Assigned Staff:</b></td>
					<td><select name="assigned_staff">
					<option value=""> - please select - </option>
					<?php foreach ($staffs as $staff) { ?>
					<?php if ($staff['staff_id'] === $staff_id) { ?>
						<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assigned_staff', $staff['staff_id'], TRUE); ?> ><?php echo $staff['staff_name']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assigned_staff', $staff['staff_id']); ?> ><?php echo $staff['staff_name']; ?></option>
					<?php } ?>
					<?php } ?>
					</select></td>
				</tr>    	
			</table>
		</div>

		<div id="restaurant" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Name:</b></td>
					<td><?php echo $location_name; ?></td>
				</tr>
				<tr>
					<td><b>Address:</b></td>
					<td><address><?php echo $location_address_1; ?>, <?php echo $location_city; ?>, <?php echo $location_postcode; ?>, <?php echo $location_country; ?></address></td>
				</tr>
			</table>
		</div>

		<div id="customer" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Name:</b></td>
					<td><?php echo $first_name; ?> <?php echo $last_name; ?></td>
				</tr>
				<tr>
					<td><b>Email:</b></td>
					<td><?php echo $email; ?></td>
				</tr>
				<tr>
					<td><b>Telephone:</b></td>
					<td><?php echo $telephone; ?></td>
				</tr>
				<?php if ($order_type === '1') { ?>
				<tr>
					<td><b>Address:</b></td>
					<td><address><?php echo $address_1; ?>, <?php echo $address_2; ?>, <?php echo $city; ?> <?php echo $postcode; ?> <?php echo $country; ?></address></td>
				</tr>    	
				<?php } ?>
				<tr>
					<td><b>Comment:</b></td>
					<td><?php echo $comment; ?></td>
				</tr>
			</table>
		</div>

		<div id="payment" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Payment Method:</b></td>
					<td><?php echo $payment; ?>
					<?php if ($paypal_details) { ?>
					<a class="view_details">View Transaction Details</a><br />
					<div class="paypal_details" style="display:none"><table>
					<?php foreach ($paypal_details as $key => $value) { ?>
					<tr>
						<td><?php echo $key; ?></td>
						<td><?php echo $value; ?></td>
					</tr>
					<?php } ?>
					</table></div>
					<?php } ?>
					</td>
				</tr>    	
			</table>
		</div>

		<div id="menus" class="wrap_content" style="display:none;">
			<table height="auto" class="list">
				<tr>
					<th class="food_name" width="25%">Name/Options</th>
					<th width="25%">Price</th>
					<th width="25%">Quantity</th>
					<th width="25%">Sub Total</th>
				</tr>
				<?php foreach ($cart_items as $cart_item) { ?>
				<tr id="<?php echo $cart_item['id']; ?>">
					<td class="food_name"><?php echo $cart_item['name']; ?><br />
					<?php if (!empty($cart_item['options'])) { ?>
					<?php foreach ($cart_item['options'] as $option_name => $option_value) { ?>
						<div><font size="1"><strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?> </font></div>
					<?php } ?>
					<?php } ?>
					</td>
					<td><?php echo $cart_item['price']; ?></td>
					<td><?php echo $cart_item['qty']; ?></td>
					<td><?php echo $cart_item['subtotal']; ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td><b>TOTAL</b></td>
					<td></td>
					<td></td>
					<td><b><?php echo $order_total; ?></b></td>
				</tr>    	
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