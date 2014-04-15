<div class="box">
	<div id="update-box" class="content">
	<h2>Cash On Delivery Details</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align=""class="form">
		<tr>
    		<td><b>Order Total:</b></td>
            <td><input type="text" name="cod_total" value="<?php echo $cod_total; ?>" /></td>
		</tr>
		<tr>
    		<td><b>Order Status:</b><br />
    		<font size="1">Default order status when cod is the payment method</font></td>
    		<td><select name="cod_order_status">
			<?php foreach ($statuses as $status) { ?>
			<?php if ($status['status_id'] === $cod_order_status) { ?>
  				<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="cod_status">
	   			<option value="0" <?php echo set_select('cod_status', '0'); ?> >Disabled</option>
     		<?php if ($cod_status === '1') { ?>
    			<option value="1" <?php echo set_select('cod_status', '1', TRUE); ?> >Enabled</option>
			<?php } else { ?>  
    			<option value="1" <?php echo set_select('cod_status', '1'); ?> >Enabled</option>
			<?php } ?>  
    		</select></td>
		</tr>
	</table>
	</form>
	</div>
</div>