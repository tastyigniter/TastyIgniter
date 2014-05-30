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
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general" class="active">Details</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table align=""class="form">
				<tbody>
					<tr>
						<td><b>API Username:</b></td>
						<td><input type="text" name="paypal_user" value="<?php echo $paypal_user; ?>" /></td>
					</tr>
					<tr>
						<td><b>API Password:</b></td>
						<td><input type="text" name="paypal_pass" value="<?php echo $paypal_pass; ?>" /></td>
					</tr>
					<tr>
						<td><b>API Signature:</b></td>
						<td><input type="text" name="paypal_sign" value="<?php echo $paypal_sign; ?>" /></td>
					</tr>
					<tr>
						<td><b>Mode:</b></td>
						<td><select name="paypal_mode">
						<?php if ($paypal_mode === 'sandbox') { ?>
							<option value="sandbox" selected="selected">Testing (sandbox)</option>
							<option value="live">Go Live</option>
						<?php } else if ($paypal_mode === 'live') { ?>
							<option value="sandbox">Testing (sandbox)</option>
							<option value="live" selected="selected">Go Live</option>
						<?php } else { ?>
							<option value="sandbox" selected="selected">Testing (sandbox)</option>
							<option value="live">Go Live</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Payment Action:</b></td>
						<td><select name="paypal_action">
						<?php if ($paypal_action === 'sale') { ?>
							<option value="sale" selected="selected">SALE</option>
							<option value="authorization">AUTHORIZATION</option>
						<?php } else if ($paypal_action === 'authorization') { ?>
							<option value="sale">SALE</option>
							<option value="authorization" selected="selected">AUTHORIZATION</option>
						<?php } else { ?>
							<option value="sale" selected="selected">SALE</option>
							<option value="authorization">AUTHORIZATION</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Order Total:</b></td>
						<td><input type="text" name="paypal_total" value="<?php echo $paypal_total; ?>" /></td>
					</tr>
					<tr>
						<td><b>Order Status:</b><br />
						<font size="1">Default order status when paypal is the payment method</font></td>
						<td><select name="paypal_order_status">
						<?php foreach ($statuses as $status) { ?>
						<?php if ($status['status_id'] === $paypal_order_status) { ?>
							<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
						<?php } else { ?>  
							<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
						<?php } ?>  
						<?php } ?>  
						</select></td>
					</tr>
					<tr>
						<td><b>Status:</b></td>
						<td><select name="paypal_status">
							<option value="0" <?php echo set_select('paypal_status', '0'); ?> >Disabled</option>
						<?php if ($paypal_status === '1') { ?>
							<option value="1" <?php echo set_select('paypal_status', '1', TRUE); ?> >Enabled</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('paypal_status', '1'); ?> >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
	</div>
</div>