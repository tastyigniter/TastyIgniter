<div class="box">
	<div id="update-box" class="content">
	<h2>UPDATE</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table align=""class="form">
		<tr>
    		<td><b>API Username:</b></td>
            <td><input type="text" name="config_paypal_user" value="<?php echo $config_paypal_user; ?>" /></td>
		</tr>
		<tr>
    		<td><b>API Password:</b></td>
            <td><input type="text" name="config_paypal_pass" value="<?php echo $config_paypal_pass; ?>" /></td>
		</tr>
		<tr>
    		<td><b>API Signature:</b></td>
            <td><input type="text" name="config_paypal_sign" value="<?php echo $config_paypal_sign; ?>" /></td>
		</tr>
		<tr>
    		<td><b>Mode:</b></td>
    		<td><select name="config_paypal_mode">
    		<?php if ($config_paypal_mode === 'sandbox') { ?>
  				<option value="sandbox" selected="selected">Testing (sandbox)</option>
  				<option value="live">Go Live</option>
    		<?php } else if ($config_paypal_mode === 'live') { ?>
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
    		<td><select name="config_paypal_action">
    		<?php if ($config_paypal_action === 'sale') { ?>
  				<option value="sale" selected="selected">SALE</option>
  				<option value="authorization">AUTHORIZATION</option>
    		<?php } else if ($config_paypal_action === 'authorization') { ?>
  				<option value="sale">SALE</option>
  				<option value="authorization" selected="selected">AUTHORIZATION</option>
    		<?php } else { ?>
  				<option value="sale" selected="selected">SALE</option>
  				<option value="authorization">AUTHORIZATION</option>
    		<?php } ?>
    		</select></td>
		</tr>
		<tr>
    		<td><b>Order Status:</b><br />
    		<font size="1">Default order status when paypal is the payment method</font></td>
    		<td><select name="config_paypal_order_status">
			<?php foreach ($statuses as $status) { ?>
			<?php if ($status['status_id'] === $config_paypal_order_status) { ?>
  				<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="config_paypal_status">
	   			<option value="0" <?php echo set_select('config_paypal_status', '0'); ?> >Disabled</option>
     		<?php if ($config_paypal_status === '1') { ?>
    			<option value="1" <?php echo set_select('config_paypal_status', '1', TRUE); ?> >Enabled</option>
			<?php } else { ?>  
    			<option value="1" <?php echo set_select('config_paypal_status', '1'); ?> >Enabled</option>
			<?php } ?>  
    		</select></td>
		</tr>
	</table>
	</form>
	</div>
</div>