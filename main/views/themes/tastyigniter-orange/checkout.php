<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
				</div>
			</div>
		</div>

		<div class="row">
			<?php echo $content_left; ?>
			<?php
				if (!empty($content_left) AND !empty($content_right)) {
					$class = "col-sm-6 col-md-6";
				} else if (!empty($content_left) OR !empty($content_right)) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="<?php echo $class; ?>">
				<div class="row">
					<div class="col-xs-12">
						<ul class="nav nav-pills nav-justified thumbnail">
							<li class="<?php echo ($post_checkout ? '' : 'active'); ?>">
								<a <?php echo ($post_checkout ? 'href="'.site_url('checkout').'"' : 'href="#checkout"'); ?>>
									<h4 class="list-group-item-heading">Step 1</h4>
									<p class="list-group-item-text">Your Details</p>
								</a>
							</li>
							<li class="<?php echo ($post_checkout ? 'active' : 'disabled'); ?>">
								<a href="#payment">
									<h4 class="list-group-item-heading">Step 2</h4>
									<p class="list-group-item-text">Payment</p>
								</a>
							</li>
							<li class="disabled">
								<a href="#confirmation">
									<h4 class="list-group-item-heading">Step 3</h4>
									<p class="list-group-item-text">Confirmation</p>
								</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">

						<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>" id="checkout-form" role="form">

							<div id="checkout" style="display: <?php echo ($post_checkout ? 'none' : 'block'); ?>">
								<p class="text-info"><?php echo $text_login_register; ?></p><br />

								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="first-name"><?php echo $entry_first_name; ?></label>
											<input type="text" name="first_name" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
											<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="last-name"><?php echo $entry_last_name; ?></label>
											<input type="text" name="last_name" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" />
											<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="email"><?php echo $entry_email; ?></label>
											<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" />
											<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="telephone"><?php echo $entry_telephone; ?></label>
											<input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo set_value('telephone', $telephone); ?>" />
											<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
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
											<?php echo form_error('order_time', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-sm-6">
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
										<?php echo form_error('order_type', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>

								<div id="checkout-delivery">
									<div class="row">
										<div class="col-sm-6">
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
											<?php echo form_error('new_address', '<span class="text-danger">', '</span>'); ?>
											<br /><br />
										</div>
									</div>

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
										<?php echo form_error('existing_address', '<span class="text-danger">', '</span>'); ?>
									</div>
									<?php } ?>

									<div id="new-address" style="display: <?php echo ($addresses ? 'none' : 'block'); ?>">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label for=""><?php echo $entry_address_1; ?></label>
													<input type="text" name="address[address_1]" class="form-control" value="<?php echo set_value('address[address_1]'); ?>" />
													<?php echo form_error('address[address_1]', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label for=""><?php echo $entry_address_2; ?></label>
													<input type="text" name="address[address_2]" class="form-control" value="<?php echo set_value('address[address_2]'); ?>" />
													<?php echo form_error('address[address_2]', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label for=""><?php echo $entry_city; ?></label>
													<input type="text" name="address[city]" class="form-control" value="<?php echo set_value('address[city]'); ?>" />
													<?php echo form_error('address[city]', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label for=""><?php echo $entry_postcode; ?></label>
													<input type="text" name="address[postcode]" class="form-control" value="<?php echo set_value('address[postcode]'); ?>" />
													<?php echo form_error('address[postcode]', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
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
											<?php echo form_error('address[country]', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for=""><?php echo $entry_comments; ?></label>
									<textarea name="comment" id="comment" rows="5" class="form-control"></textarea>
									<?php echo form_error('comment', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>

							<div id="payment" style="display: <?php echo ($post_checkout ? 'block' : 'none'); ?>">
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="post_checkout" value="<?php echo $post_checkout; ?>" />
										<label for=""><?php echo $entry_payment_method; ?></label><br />
										<?php foreach ($payments as $payment) { ?>
											<div class="radio">
												<label>
													<input type="radio" name="payment" class="payment_radio" value="<?php echo $payment['code']; ?>" <?php echo set_radio('payment', $payment['code']); ?> />
													<?php echo $payment['name']; ?>
												</label>
											</div>
										<?php } ?>
										<?php echo form_error('payment', '<span class="text-danger">', '</span>'); ?>
										<br />
										<div class="form-group">
											<label for=""><?php echo $entry_ip; ?></label>
											<?php echo $ip_address; ?><br /><font size="1"><?php echo $text_ip_warning; ?></font>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="buttons col-sm-6">
									<?php echo $button_back; ?>
									<?php echo $button_continue; ?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php echo $content_right; ?>
			<?php echo $content_bottom; ?>
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