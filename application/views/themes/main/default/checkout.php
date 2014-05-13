<div class="content">
<div class="img_inner">
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="checkout-form">
	<div id="checkout" style="display: <?php echo ($post_checkout ? 'none' : 'block'); ?>">
	<!--<h3>Personal Details</h3>-->
		<table border="0" cellpadding="2" width="100%" id="personal-details" class="form">
		<tr>
			<td align="right"><b><?php echo $entry_first_name; ?></b></td>
			<td><input type="text" name="first_name" value="<?php echo set_value('first_name', $first_name); ?>" /><br />
    			<?php echo form_error('first_name', '<span class="error">', '</span>'); ?></td>
		</tr>
		<tr>
			<td align="right"><b><?php echo $entry_last_name; ?></b></td>
			<td><input type="text" name="last_name" value="<?php echo set_value('last_name', $last_name); ?>" /><br />
    			<?php echo form_error('last_name', '<span class="error">', '</span>'); ?></td>
		</tr>
		<tr>
			<td align="right"><b><?php echo $entry_email; ?></b></td>
			<td><input type="text" name="email" value="<?php echo set_value('email', $email); ?>" /><br />
    			<?php echo form_error('email', '<span class="error">', '</span>'); ?></td>
		</tr>
		<tr>
			<td align="right"><b><?php echo $entry_telephone; ?></b></td>
			<td><input type="text" name="telephone" value="<?php echo set_value('telephone', $telephone); ?>" /><br />
    			<?php echo form_error('telephone', '<span class="error">', '</span>'); ?></td>
		</tr>
		</table>

		<table border="0" cellpadding="2" width="100%" id="collection-time" class="form">
		<tr>
			<td align="right"><b><?php echo $entry_order_type; ?></b></td>
			<td>
				<?php if ($order_type === '1') { ?>
					<input type="radio" class="order_type" name="order_type" value="1" checked="checked" /> <?php echo $entry_delivery; ?><br />
					<input type="radio" class="order_type" name="order_type" value="2" /> <?php echo $entry_collection; ?><br />
				<?php } else if ($order_type === '2') { ?>
					<input type="radio" class="order_type" name="order_type" value="1" /> <?php echo $entry_delivery; ?><br />
					<input type="radio" class="order_type" name="order_type" value="2" checked="checked" /> <?php echo $entry_collection; ?><br />
				<?php } else { ?>
					<input type="radio" class="order_type" name="order_type" value="1" /> <?php echo $entry_delivery; ?><br />
					<input type="radio" class="order_type" name="order_type" value="2" checked="checked" /> <?php echo $entry_collection; ?><br />
				<?php } ?>
				<?php echo form_error('order_type', '<span class="error">', '</span>'); ?>
    		</td>
		</tr>
		<tr>
			<td align="right"><b><?php echo $entry_order_time; ?></b></td>
			<td><select name="order_time">
					<option value="<?php echo $asap_time; ?>"><?php echo $text_asap; ?></option>
				<?php foreach ($delivery_times as $delivery_time) { ?>
				<?php if ($delivery_time['24hr'] === $order_time) { ?>
					<option value="<?php echo $delivery_time['24hr']; ?>" selected="selected"><?php echo $delivery_time['12hr']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $delivery_time['24hr']; ?>"><?php echo $delivery_time['12hr']; ?></option>
				<?php } ?>
				<?php } ?>
			</select><br />
    		<?php echo form_error('order_time', '<span class="error">', '</span>'); ?></td>
		</tr>
		</table>

		<div id="checkout-delivery">
		<table border="0" cellpadding="2" width="100%" id="delivery-details" class="form">
		<?php if ($addresses) { ?>
		<tr>
			<td align="right"><b><?php echo $entry_use_address; ?></b></td>
			<td>
			<?php if ($new_address === '1') { ?>
				<input type="radio" class="use-address" name="new_address" value="2" /> <?php echo $text_existing; ?>  
				<input type="radio" class="use-address" name="new_address" value="1" checked="checked" /> <?php echo $text_new; ?>  
			<?php } else if ($new_address === '2') { ?>
				<input type="radio" class="use-address" name="new_address" value="2" checked="checked" /> <?php echo $text_existing; ?>  
				<input type="radio" class="use-address" name="new_address" value="1"/> <?php echo $text_new; ?>  
			<?php } else {?>
				<input type="radio" class="use-address" name="new_address" value="2" checked="checked" /> <?php echo $text_existing; ?>  
				<input type="radio" class="use-address" name="new_address" value="1" /> <?php echo $text_new; ?><br />
			<?php } ?>
    		
    		<?php echo form_error('new_address', '<span class="error">', '</span>'); ?>
    		</td>
		</tr>
		<?php } else { ?>
		<tr>
			<td align="right"><b><?php echo $entry_use_address; ?></b></td>
			<td>
				<input type="radio" class="use-address" name="new_address" value="1" checked="checked" /> <?php echo $text_new; ?>  
	
    			<?php echo form_error('new_address', '<span class="error">', '</span>'); ?>
    		</td>
		</tr>
		<?php } ?>
		</table>

		<?php if ($addresses) { ?>
		<table id="existing-address" class="form" border="0" cellpadding="2" width="100%">	
		<tr>
			<td align="right"><b><?php echo $entry_address; ?></b></td>
			<td>
			<?php foreach ($addresses as $address) { ?>
			<?php if ($address['address_id'] == $existing_address) { ?>
				<input type="radio" name="existing_address" value="<?php echo $address['address_id']; ?>" checked="checked" />  <?php echo $address['address_1']; ?>, <?php echo $address['address_2']; ?>, <?php echo $address['city']; ?> <?php echo $address['postcode']; ?> <?php echo $address['country']; ?><br />
			<?php } else { ?>
				<input type="radio" name="existing_address" value="<?php echo $address['address_id']; ?>" />  <?php echo $address['address_1']; ?>, <?php echo $address['address_2']; ?>, <?php echo $address['city']; ?> <?php echo $address['postcode']; ?> <?php echo $address['country']; ?><br />
			<?php } ?>
			<?php } ?><br />
			<?php echo form_error('existing_address', '<span class="error">', '</span>'); ?></td>
		</tr>
		</table>
		<?php } ?>

		<table id="new-address" class="form" border="0" cellpadding="2" width="100%" style="display: <?php echo ($addresses ? 'none' : 'block'); ?>">	
		<tr>
			<td align="right"><b><?php echo $entry_address_1; ?></b></td>
			<td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]'); ?>" /><br />
    			<?php echo form_error('address[address_1]', '<span class="error">', '</span>'); ?></td>
		</tr>
		<tr>
			<td align="right"><b><?php echo $entry_address_2; ?></b></td>
			<td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]'); ?>" /><br />
    			<?php echo form_error('address[address_2]', '<span class="error">', '</span>'); ?></td>
		</tr>
		<tr>
			<td align="right"><b><?php echo $entry_city; ?></b></td>
			<td><input type="text" name="address[city]" value="<?php echo set_value('address[city]'); ?>" /><br />
    			<?php echo form_error('address[city]', '<span class="error">', '</span>'); ?></td>
		</tr>
		<tr>
			<td align="right"><b><?php echo $entry_postcode; ?></b></td>
			<td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]'); ?>" /><br />
    			<?php echo form_error('address[postcode]', '<span class="error">', '</span>'); ?></td>
		</tr>
		<tr>
			<td align="right"><b><?php echo $entry_country; ?></b></td>
			<td><select name="address[country]">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $country_id) { ?>
				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
			</select><br />
    		<?php echo form_error('address[country]', '<span class="error">', '</span>'); ?></td>
		</tr>
		</table>
		</div>

		<table border="0" cellpadding="2" width="100%" id="comment" class="form">
		<tr>
			<td align="right"><b><?php echo $entry_comments; ?></b></td>
			<td><textarea name="comment" rows="5" cols="40"></textarea><br />
    			<?php echo form_error('comment', '<span class="error">', '</span>'); ?></td>
		</tr>
		</table>
	</div>    

	<div id="payment" style="display: <?php echo ($post_checkout ? 'block' : 'none'); ?>">
		<h3><?php echo $text_payments; ?></h3>
		<input type="hidden" name="post_checkout" value="<?php echo $post_checkout; ?>" />
		<div>
		<table border="0" cellpadding="2" width="100%" id="payment-method" class="form">
			<tr>
				<td align="right"><b><?php echo $entry_payment_method; ?></b></td>
				<td>
					<?php if ($this->config->item('cod_status') === '1') { ?>
						<input type="radio" name="payment" class="payment_radio" value="cod" <?php echo set_radio('payment', 'cod'); ?> /><?php echo $text_cod; ?><br />
					<?php } ?>

					<?php if ($this->config->item('paypal_status') === '1') { ?>
						<input type="radio" name="payment" class="payment_radio" value="paypal" <?php echo set_radio('payment', 'paypal'); ?> /><?php echo $text_paypal; ?><br />
					<?php } ?>
					<?php echo form_error('payment', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
		</table>
	
		<table border="0" cellpadding="2" width="100%" id="" class="form">
			<tr>
				<td align="right"><b><?php echo $entry_ip; ?></b></td>
				<td><?php echo $ip_address; ?><br /><font size="1"><?php echo $text_ip_warning; ?></font></td>
			</tr>
		</table>
		</div>    
	</div>
	</form>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
  	$('#check-postcode').on('click', function() {
		$('.check-local').show();
		$('.display-local').hide();
	});	

  	if ($('.order_type:checked').val() !== '1') {
   		$('#checkout-delivery').fadeOut();
   	}

  	if ($('.use-address:checked').val() === '1') {
   		$('#new-address').fadeIn();
    	$('#existing-address').fadeOut();
   	}

  	$('.use-address').on('change', function() {
  		if (this.value === '1') {
     		$('#new-address').fadeIn();
     		$('#existing-address').fadeOut();
		} else {
   			$('#new-address').fadeOut();
   			$('#existing-address').fadeIn();
		}
	});	

  	$('.order_type').on('change', function() {
  		if (this.value === '1') {
     		$('#checkout-delivery').fadeIn();
		} else {
   			$('#checkout-delivery').fadeOut();
		}
	});	
});
//--></script> 
