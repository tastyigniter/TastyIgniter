<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">Reservation</a></li>
				<li><a rel="#status">Status & Assign</a></li>
				<li><a rel="#table">Table</a></li>
				<li><a rel="#restaurant">Restaurant</a></li>
				<li><a rel="#customer">Customer</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tr>
					<td><b>Reservation ID:</b></td>
					<td>#<?php echo $reservation_id; ?></td>
				</tr>
				<tr>
					<td><b>Guest Number:</b></td>
					<td><?php echo $guest_num; ?></td>
				</tr>    	
				<tr>
					<td><b>Reservation Date:</b></td>
					<td><?php echo $reserve_date; ?></td>
				</tr>    	
				<tr>
					<td><b>Reservation Time:</b></td>
					<td><?php echo $reserve_time; ?></td>
				</tr>    	
				<tr>
					<td><b>Occasion:</b></td>
					<td><?php echo $occasions[$occasion]; ?></td>
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
						Reservation Confirmation Email SENT
					<?php } else { ?>
						Reservation Confirmation Email not SENT
					<?php } ?>
				</tr>
				<tr>
					<td><b>Customer IP:</b></td>
					<td><?php echo $ip_address; ?></td>
				</tr>    	
				<tr>
					<td><b>Customer User Agent:</b></td>
					<td><?php echo $user_agent; ?></td>
				</tr>    	
			</table>
		</div>

		<div id="status" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Reservation Status:</b></td>
					<td><select name="status">
					<?php foreach ($statuses as $status) { ?>
					<?php if ($status['status_id'] === $status_id) { ?>
						<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
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

		<div id="table" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Table Name:</b></td>
					<td><?php echo $table_name; ?></td>
				</tr>
				<tr>
					<td><b>Table Minimum:</b></td>
					<td><?php echo $min_capacity; ?></td>
				</tr>
				<tr>
					<td><b>Table Capacity:</b></td>
					<td><?php echo $max_capacity; ?></td>
				</tr>
			</table>
		</div>
	
		<div id="restaurant" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Restaurant Name:</b></td>
					<td><?php echo $location_name; ?></td>
				</tr>
				<tr>
					<td><b>Restaurant Address:</b></td>
					<td><address><?php echo $location_address_1; ?>, <?php echo $location_city; ?>, <?php echo $location_postcode; ?>, <?php echo $location_country; ?></address></td>
				</tr>
			</table>
		</div>
	
		<div id="customer" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Customer Name:</b></td>
					<td><?php echo $first_name; ?> <?php echo $last_name; ?></td>
				</tr>
				<tr>
					<td><b>Customer Email:</b></td>
					<td><?php echo $email; ?></td>
				</tr>
				<tr>
					<td><b>Customer Telephone:</b></td>
					<td><?php echo $telephone; ?></td>
				</tr>
				<tr>
					<td><b>Comment:</b></td>
					<td><?php echo $comment; ?></td>
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
