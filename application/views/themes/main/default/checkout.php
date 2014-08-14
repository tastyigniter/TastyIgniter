<?php echo $header; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<?php echo $content_top; ?>

<div id="notification" class="row">
<?php if (!empty($alert)) { ?>
	<div class="alert alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $alert; ?>
	</div>
<?php } ?>
</div>
<div class="row content">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-md-8 page-content">
		<div class="row wrap-all">
			<p class="text-info well"><?php echo $text_login_register; ?></p>

			<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>" id="checkout-form" role="form">
				<div id="checkout" class="row wrap-all" style="display: <?php echo ($post_checkout ? 'none' : 'block'); ?>">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="first-name"><?php echo $entry_first_name; ?></label>
							<input type="text" name="first_name" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
							<?php echo form_error('first_name', '<span class="error help-block">', '</span>'); ?>
						</div>
						<div class="form-group">
							<label for="last-name"><?php echo $entry_last_name; ?></label>
							<input type="text" name="last_name" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" />
							<?php echo form_error('last_name', '<span class="error help-block">', '</span>'); ?>
						</div>
						<div class="form-group">
							<label for="email"><?php echo $entry_email; ?></label>
							<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" />
							<?php echo form_error('email', '<span class="error help-block">', '</span>'); ?>
						</div>
						<div class="form-group">
							<label for="telephone"><?php echo $entry_telephone; ?></label>
							<input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo set_value('telephone', $telephone); ?>" />
							<?php echo form_error('telephone', '<span class="error help-block">', '</span>'); ?>
						</div>
				
						<div class="">
							<label for=""><?php echo $entry_order_type; ?></label><br />
							<?php if ($order_type === '1') { ?>
								<label class="radio-inline">
									<input type="radio" class="order_type" name="order_type" value="1" checked="checked" /> <?php echo $entry_delivery; ?>
								</label>
								<label class="radio-inline">
									<input type="radio" class="order_type" name="order_type" value="2" /> <?php echo $entry_collection; ?>
								</label>
							<?php } else if ($order_type === '2') { ?>
								<label class="radio-inline">
									<input type="radio" class="order_type" name="order_type" value="1" /> <?php echo $entry_delivery; ?>
								</label>
								<label class="radio-inline">
									<input type="radio" class="order_type" name="order_type" value="2" checked="checked" /> <?php echo $entry_collection; ?>
								</label>
							<?php } else { ?>
								<label class="radio-inline">
									<input type="radio" class="order_type" name="order_type" value="1" /> <?php echo $entry_delivery; ?>
								</label>
								<label class="radio-inline">
									<input type="radio" class="order_type" name="order_type" value="2" checked="checked" /> <?php echo $entry_collection; ?>
								</label>
							<?php } ?>
							<?php echo form_error('order_type', '<span class="error help-block">', '</span>'); ?>
						</div><br />
						<div class="form-group">
							<label for="order-time"><?php echo $entry_order_time; ?></label>
							<select name="order_time" id="order-time" class="form-control">
								<option value="<?php echo $asap_time; ?>"><?php echo $text_asap; ?></option>
								<?php foreach ($delivery_times as $delivery_time) { ?>
									<?php if ($delivery_time['24hr'] === $order_time) { ?>
										<option value="<?php echo $delivery_time['24hr']; ?>" selected="selected"><?php echo $delivery_time['12hr']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $delivery_time['24hr']; ?>"><?php echo $delivery_time['12hr']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('order_time', '<span class="error help-block">', '</span>'); ?>
						</div>

						<div class="form-group">
							<label for=""><?php echo $entry_comments; ?></label>
							<textarea name="comment" id="comment" rows="5" class="form-control"></textarea>
							<?php echo form_error('comment', '<span class="error help-block">', '</span>'); ?>
						</div>
					</div>
			
					<div class="col-xs-6">
						<div id="checkout-delivery">
							<label for=""><?php echo $entry_address; ?></label><br />
							<?php if ($addresses) { ?>
								<?php if ($new_address === '1') { ?>
									<label class="radio-inline">
										<input type="radio" class="use-address" name="new_address" value="0" /> <?php echo $text_existing; ?>  
									</label>
									<label class="radio-inline">
										<input type="radio" class="use-address" name="new_address" value="1" checked="checked" /> <?php echo $text_new; ?>  
									</label>
								<?php } else {?>
									<label class="radio-inline">
										<input type="radio" class="use-address" name="new_address" value="0" checked="checked" /> <?php echo $text_existing; ?>  
									</label>
									<label class="radio-inline">
										<input type="radio" class="use-address" name="new_address" value="1" /> <?php echo $text_new; ?>
									</label>
								<?php } ?>
							<?php } else { ?>
								<label class="radio-inline">
									<input type="radio" class="use-address" name="new_address" value="1" checked="checked" /> <?php echo $text_new; ?>  
								</label>
							<?php } ?>
							<?php echo form_error('new_address', '<span class="error help-block">', '</span>'); ?>
							<br /><br />
				
							<?php if ($addresses) { ?>
							<div id="existing-address">	
								<div class="btn-group btn-group-md col-xs-12 wrap-none" data-toggle="buttons">
								<?php foreach ($addresses as $address) { ?>
									<?php if ($address['address_id'] == $existing_address) { ?>
									<label class="btn btn-default wrap-all col-xs-6 active">
										<input type="radio" name="existing_address" value="<?php echo $address['address_id']; ?>" checked="checked" />
										<address class="text-left"><?php echo $address['address']; ?></address>
									</label>
									<?php } else { ?>
									<label class="btn btn-default wrap-all col-xs-6">
										<input type="radio" name="existing_address" value="<?php echo $address['address_id']; ?>" />
										<address class="text-left"><?php echo $address['address']; ?></address>
									</label>
									<?php } ?>
								<?php } ?>
								</div>
								<?php echo form_error('existing_address', '<span class="error help-block">', '</span>'); ?>
							</div>
							<?php } ?>

							<div id="new-address" style="display: <?php echo ($addresses ? 'none' : 'block'); ?>">	
								<div class="form-group">
									<label for=""><?php echo $entry_address_1; ?></label>
									<input type="text" name="address[address_1]" class="form-control" value="<?php echo set_value('address[address_1]'); ?>" />
									<?php echo form_error('address[address_1]', '<span class="error help-block">', '</span>'); ?>
								</div>
								<div class="form-group">
									<label for=""><?php echo $entry_address_2; ?></label>
									<input type="text" name="address[address_2]" class="form-control" value="<?php echo set_value('address[address_2]'); ?>" />
									<?php echo form_error('address[address_2]', '<span class="error help-block">', '</span>'); ?>
								</div>
								<div class="form-group">
									<label for=""><?php echo $entry_city; ?></label>
									<input type="text" name="address[city]" class="form-control" value="<?php echo set_value('address[city]'); ?>" />
									<?php echo form_error('address[city]', '<span class="error help-block">', '</span>'); ?>
								</div>
								<div class="form-group">
									<label for=""><?php echo $entry_postcode; ?></label>
									<input type="text" name="address[postcode]" class="form-control" value="<?php echo set_value('address[postcode]'); ?>" />
									<?php echo form_error('address[postcode]', '<span class="error help-block">', '</span>'); ?>
								</div>
								<div class="form-group">
									<label for=""><?php echo $entry_country; ?></label>
									<select name="address[country]" class="form-control">
										<?php foreach ($countries as $country) { ?>
										<?php if ($country['country_id'] === $country_id) { ?>
											<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
										<?php } else { ?>  
											<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
										<?php } ?>  
										<?php } ?>  
									</select>
									<?php echo form_error('address[country]', '<span class="error help-block">', '</span>'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>    

				<div id="payment" class="row" style="display: <?php echo ($post_checkout ? 'block' : 'none'); ?>">
					<div class="col-xs-6">
						<input type="hidden" name="post_checkout" value="<?php echo $post_checkout; ?>" />
						<label for=""><?php echo $entry_payment_method; ?></label><br />
						<?php foreach ($payments as $payment) { ?>
							<div class="radio">
								<label>
									<input type="radio" name="payment" class="payment_radio" value="<?php echo $payment['code']; ?>" <?php echo set_radio('payment', $payment['code']); ?> /><?php echo $payment['name']; ?>
								</label>
							</div>
						<?php } ?>
						<?php echo form_error('payment', '<span class="error help-block">', '</span>'); ?>
						<br />
						<div class="form-group">
							<label for=""><?php echo $entry_ip; ?></label>
							<?php echo $ip_address; ?><br /><font size="1"><?php echo $text_ip_warning; ?></font>
						</div>
					</div>
				</div>

				<div class="row wrap-vertical">
					<div class="buttons col-xs-6 wrap">
						<?php echo $button_back; ?>
						<!--<?php echo $button_continue; ?>-->
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  	if ($('.order_type:checked').val() !== '1') {
   		$('#checkout-delivery').fadeOut();
   	}

  	$('.order_type').on('change', function() {
  		if (this.value === '1') {
     		$('#checkout-delivery').fadeIn();
		} else {
   			$('#checkout-delivery').fadeOut();
		}
	});	

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
});
//--></script> 
<?php echo $footer; ?>