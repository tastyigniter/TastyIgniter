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
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">Coupon</a></li>
				<li><a rel="#coupon-history">History</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Coupon Name:</b></td>
						<td><input type="text" name="name" value="<?php echo set_value('name', $name); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Coupon Code:</b></td>
						<td><input type="text" name="code" value="<?php echo set_value('code', $code); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Coupon Type:</b></td>
						<td><select name="type">
						<?php if ($type === 'F') { ?>
							<option value="F" <?php echo set_select('type', 'F', TRUE); ?> >Fixed Amount</option>
							<option value="P" <?php echo set_select('type', 'P'); ?> >Percentage</option>
						<?php } else if ($type === 'P') { ?>
							<option value="F" <?php echo set_select('type', 'F'); ?> >Fixed Amount</option>
							<option value="P" <?php echo set_select('type', 'P', TRUE); ?> >Percentage</option>
						<?php } else { ?>  
							<option value="F" <?php echo set_select('type', 'F'); ?> >Fixed Amount</option>
							<option value="P" <?php echo set_select('type', 'P'); ?> >Percentage</option>
						<?php } ?>  
						</select></td>
					</tr>
					<tr>
						<td><b>Coupon Discount:</b></td>
						<td><input type="text"  name="discount" value="<?php echo set_value('discount', $discount); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Coupon Redemptions:</b><br />
						<font size="1">The total number of times this coupon can be redeem. Enter 0 for unlimited redemptions.</font></td>
						<td><input type="text"  name="redemptions" value="<?php echo set_value('redemptions', $redemptions); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Customer Redemptions:</b><br />
						<font size="1">The number of times a specific customer can redeem this coupon. Enter 0 for unlimited redemptions.</font></td>
						<td><input type="text"  name="customer_redemptions" value="<?php echo set_value('customer_redemptions', $customer_redemptions); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Minimum Total:</b></td>
						<td><input type="text"  name="min_total" value="<?php echo set_value('min_total', $min_total); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Coupon Description:</b></td>
						<td><textarea name="description" cols="50" rows="7"><?php echo set_value('description', $description); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Start Date:</b></td>
						<td><input type="text"  name="start_date" id="start-date" value="<?php echo set_value('start_date', $start_date); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>End Date:</b></td>
						<td><input type="text"  name="end_date" id="end-date" value="<?php echo set_value('end_date', $end_date); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Status:</b></td>
						<td><select name="status">
							<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
						<?php if ($status === '1') { ?>
							<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="coupon-history" class="wrap_content" style="display:none;">
			<table height="auto" class="list" id="history">
				<tr>
					<th class="right">Order ID</th>
					<th width="55%">Customer</th>
					<th class="center">Code</th>
					<th class="center">Amount</th>
					<th class="center">Used</th>
					<th class="right">Date Used</th>
				</tr>
				<?php if ($coupon_histories) { ?>
				<?php foreach ($coupon_histories as $coupon_history) { ?>
				<tr>
					<td class="right"><?php echo $coupon_history['order_id']; ?></td>
					<td><?php echo $coupon_history['customer_name']; ?></td>
					<td class="center"><?php echo $coupon_history['code']; ?></td>
					<td class="center"><?php echo $coupon_history['amount']; ?></td>
					<td class="center"><a href="<?php echo $coupon_history['used_url']; ?>"><?php echo $coupon_history['used']; ?></a></td>
					<td class="right"><?php echo $coupon_history['date_used']; ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="6" align="center"><?php echo $text_empty; ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'dd-mm-yy',
	});
});
$('#tabs a').tabs();
//--></script>