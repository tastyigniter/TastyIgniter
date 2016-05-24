<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<?php echo get_partial('content_left'); ?>
			<?php
				if (partial_exists('content_left') AND partial_exists('content_right')) {
					$class = "col-sm-5 col-md-6";
				} else if (partial_exists('content_left') OR partial_exists('content_right')) {
					$class = "col-sm-8 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="<?php echo $class; ?>">
				<div class="row">
					<div class="col-xs-12">
						<ul class="nav nav-pills nav-justified thumbnail">
							<li class="step-one <?php if ($checkout_step === 'one') { echo 'active'; } else if ($checkout_step === 'two') { echo 'link'; } else { echo 'disabled'; }; ?>">
								<a>
									<h4 class="list-group-item-heading"><?php echo lang('text_step_one'); ?></h4>
									<p class="list-group-item-text hidden-xs"><?php echo lang('text_step_one_summary'); ?></p>
								</a>
							</li>
							<li class="step-two <?php echo ($checkout_step === 'two') ? 'active' : 'disabled'; ?>">
								<a>
									<h4 class="list-group-item-heading"><?php echo lang('text_step_two'); ?></h4>
									<p class="list-group-item-text hidden-xs"><?php echo lang('text_step_two_summary'); ?></p>
								</a>
							</li>
							<li class="step-three disabled">
								<a>
									<h4 class="list-group-item-heading"><?php echo lang('text_step_three'); ?></h4>
									<p class="list-group-item-text hidden-xs"><?php echo lang('text_step_three_summary'); ?></p>
								</a>
							</li>
						</ul>
					</div>
				</div>

				<?php if ($this->alert->get()) { ?>
					<div id="notification">
						<div class="row">
							<div class="col-md-12">
								<?php echo $this->alert->display(); ?>
							</div>
						</div>
					</div>
				<?php } ?>

				<div class="row">
					<div class="col-md-12">
						<form method="POST" accept-charset="utf-8" action="<?php echo $_action; ?>" id="checkout-form" role="form">
							<input type="hidden" name="checkout_step" class="checkout_step" value="<?php echo set_value('checkout_step', $checkout_step); ?>">

							<div id="checkout" class="content-wrap" style="display: <?php echo ($checkout_step === 'one') ? 'block' : 'none'; ?>">
								<p class="text-info"><?php echo $text_login_register; ?></p><br />

								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="first-name"><?php echo lang('label_first_name'); ?></label>
											<input type="text" name="first_name" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
											<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="last-name"><?php echo lang('label_last_name'); ?></label>
											<input type="text" name="last_name" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" />
											<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="email"><?php echo lang('label_email'); ?></label>
											<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" <?php echo $is_logged ? 'disabled' : ''; ?> />
											<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="telephone"><?php echo lang('label_telephone'); ?></label>
											<input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo set_value('telephone', $telephone); ?>" />
											<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="order-time"><?php echo sprintf(lang('label_order_time'), $order_type_text); ?></label>
											<?php if ($order_times) { ?>
												<div class="btn-group" data-toggle="buttons">
													<?php if (!empty($order_times['asap'])) { ?>
														<label class="btn btn-default <?php echo ($order_time_type === 'asap') ? 'btn-primary active' : ''; ?>" data-btn="btn-primary">
															<input type="hidden" name="order_asap_time" value="<?php echo $order_times['asap']; ?>">
															<input type="radio" name="order_time_type" value="asap"  <?php echo ($order_time_type === 'asap') ? 'checked="checked"' : ''; ?>>
															<?php echo lang('text_asap'); ?>
														</label>
													<?php } ?>
													<label class="btn btn-default <?php echo ($order_time_type === 'later') ? 'btn-primary active' : ''; ?>" data-btn="btn-primary"><input type="radio" name="order_time_type" value="later"  <?php echo ($order_time_type === 'later') ? 'checked="checked"' : ''; ?>><?php echo lang('text_later'); ?></label>
												</div>
											<?php } else { ?>
												<br /><?php echo lang('text_location_closed'); ?><br />
											<?php } ?>
											<?php echo form_error('order_time', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<?php if ($order_times) { ?>
										<div class="clearfix"></div>
										<div id="choose-order-time" class="col-sm-6" style="display: <?php echo ($order_time_type === 'later') ? 'block' : 'none'; ?>;">
											<div class="form-group">
												<label for="choose-order-time"><?php echo sprintf(lang('label_choose_order_time'), $order_type_text); ?></label>
												<div class="row order-time-group">
													<div class="col-xs-12 col-sm-6 order-later date-input-addon">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															<select name="order_date" id="order-date" class="form-control">
																<?php foreach ($order_times as $date => $times) { ?>
																	<?php if ($date === 'asap' OR empty($times)) continue; ?>

																	<?php if ( ! empty($order_date) AND $date == $order_date) { ?>
																		<option value="<?php echo $date; ?>" selected="selected"><?php echo mdate(lang('text_date_format'), strtotime($date)); ?></option>
																	<?php } else { ?>
																		<option value="<?php echo $date; ?>"><?php echo mdate(lang('text_date_format'), strtotime($date)); ?></option>
																	<?php } ?>
																<?php } ?>
															</select>
															<input type="hidden" name="order_hour" value="<?php echo $order_hour; ?>">
															<input type="hidden" name="order_minute" value="<?php echo $order_minute; ?>">
														</div>
													</div>
													<div class="col-xs-12 col-sm-6 order-later time-input-addon">
														<?php foreach ($order_times as $date => $times) { ?>
															<?php if ($date === 'asap' OR empty($times)) continue; ?>
															<div id="order-time-<?php echo $date; ?>" class="input-group" style="display: <?php echo ($date == $order_date) ? 'table' : 'none'; ?>">
																<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
																<select id="hours-for-<?php echo $date; ?>" data-parent="#order-time-<?php echo $date; ?>" class="form-control hours">
																	<?php foreach ($times as $hour => $minutes) { ?>
																		<?php if ($hour == $order_hour) { ?>
																			<option value="<?php echo $hour; ?>" selected="selected"><?php echo $hour; ?>:</option>
																		<?php } else { ?>
																			<option value="<?php echo $hour; ?>"><?php echo $hour; ?>:</option>
																		<?php } ?>
																	<?php } ?>
																</select>
																<?php $count = 1; ?>
																<?php foreach ($times as $hour => $minutes) { ?>
																	<select data-parent="#order-time-<?php echo $date; ?>" class="form-control minutes minutes-for-<?php echo $hour; ?> <?php echo ($hour == $order_hour) ? '' : 'hide'; ?>">
																		<?php foreach ($minutes as $minute) { ?>
																			<?php if ($minute == $order_minute) { ?>
																				<option value="<?php echo $minute; ?>" selected="selected"><?php echo $minute; ?></option>
																			<?php } else { ?>
																				<option value="<?php echo $minute; ?>"><?php echo $minute; ?></option>
																			<?php } ?>
																		<?php } ?>
																	</select>
																	<?php $count++; ?>
																<?php } ?>
															</div>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>

								<?php if ($addresses) { ?>
									<div id="checkout-delivery" class="row wrap-bottom" style="display:<?php echo ($order_type === '1') ? 'block' : 'none'; ?>">
										<?php $address_row = 0; ?>
										<div id="address-labels">
											<div class="btn-group btn-group-md col-xs-12" data-toggle="buttons">
												<?php foreach ($addresses as $address) { ?>
													<?php if (!empty($address['address_id'])) { ?>
														<label class="btn btn-default wrap-all col-xs-12 col-sm-3 <?php echo ($address_id == $address['address_id']) ? 'btn-primary active' : ''; ?>" data-btn="btn-primary">
															<span class="edit-address pull-right" data-form="#address-form-<?php echo $address_row; ?>"><?php echo lang('text_edit'); ?></span>
															<input type="radio" name="address_id" value="<?php echo $address['address_id']; ?>" <?php echo ($address['address_id'] == $address_id) ? 'checked="checked"' : ''; ?> />
															<address class="text-left"><?php echo $address['address']; ?></address>
														</label>
													<?php } else if ($address['address_id'] === '0') { ?>
														<input type="hidden" name="address_id" value="<?php echo $address['address_id']; ?>" />
													<?php } ?>
													<?php $address_row++; ?>
												<?php } ?>
											</div>
											<div class="col-xs-12">
												<?php echo form_error('address_id', '<span class="text-danger">', '</span>'); ?>
											</div>
										</div>

										<div id="address-forms">
											<?php $address_row = 0; ?>

											<?php foreach ($addresses as $address) { ?>
												<div id="address-form-<?php echo $address_row; ?>" class="col-xs-12 wrap-horizontal" style="display: <?php echo (empty($address['address_id'])) ? 'block' : 'none'; ?>">
													<input type="hidden" name="address[<?php echo $address_row; ?>][address_id]" value="<?php echo set_value('address['.$address_row.'][address_id]', $address['address_id']); ?>">
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label for=""><?php echo lang('label_address_1'); ?></label>
																<input type="text" name="address[<?php echo $address_row; ?>][address_1]" class="form-control" value="<?php echo set_value('address['.$address_row.'][address_1]', $address['address_1']); ?>" />
																<?php echo form_error('address['.$address_row.'][address_1]', '<span class="text-danger">', '</span>'); ?>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label for=""><?php echo lang('label_address_2'); ?></label>
																<input type="text" name="address[<?php echo $address_row; ?>][address_2]" class="form-control" value="<?php echo set_value('address['.$address_row.'][address_2]', $address['address_2']); ?>" />
																<?php echo form_error('address['.$address_row.'][address_2]', '<span class="text-danger">', '</span>'); ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-4">
															<div class="form-group">
																<label for=""><?php echo lang('label_city'); ?></label>
																<input type="text" name="address[<?php echo $address_row; ?>][city]" class="form-control" value="<?php echo set_value('address['.$address_row.'][city]', $address['city']); ?>" />
																<?php echo form_error('address['.$address_row.'][city]', '<span class="text-danger">', '</span>'); ?>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for=""><?php echo lang('label_state'); ?></label>
																<input type="text" name="address[<?php echo $address_row; ?>][state]" class="form-control" value="<?php echo set_value('address['.$address_row.'][state]', $address['state']); ?>" />
																<?php echo form_error('address['.$address_row.'][state]', '<span class="text-danger">', '</span>'); ?>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for=""><?php echo lang('label_postcode'); ?></label>
																<input type="text" name="address[<?php echo $address_row; ?>][postcode]" class="form-control" value="<?php echo set_value('address['.$address_row.'][postcode]', $address['postcode']); ?>" />
																<?php echo form_error('address['.$address_row.'][postcode]', '<span class="text-danger">', '</span>'); ?>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label for=""><?php echo lang('label_country'); ?></label>
														<select name="address[<?php echo $address_row; ?>][country_id]" class="form-control">
															<?php foreach ($countries as $country) { ?>
																<?php if ($country['country_id'] === $address['country_id']) { ?>
																	<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
																<?php } else { ?>
																	<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
																<?php } ?>
															<?php } ?>
														</select>
														<?php echo form_error('address['.$address_row.'][country_id]', '<span class="text-danger">', '</span>'); ?>
													</div>
												</div>

												<?php $address_row++; ?>
											<?php } ?>
										</div>
									</div>
								<?php } ?>

								<div class="form-group wrap-top">
									<label for=""><?php echo lang('label_comment'); ?></label>
									<textarea name="comment" id="comment" rows="5" class="form-control"><?php echo set_value('comment', $comment); ?></textarea>
									<?php echo form_error('comment', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>

							<div id="payment" class="content-wrap" style="display: <?php echo ($checkout_step === 'two') ? 'block' : 'none'; ?>">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for=""><?php echo lang('label_customer_name'); ?></label><br /><?php echo $first_name; ?> <?php echo $last_name; ?>
										</div>
										<div class="form-group">
											<label for=""><?php echo lang('label_email'); ?></label><br />
											<?php echo $email; ?>
										</div>
										<div class="form-group">
											<label for=""><?php echo lang('label_telephone'); ?></label><br />
											<?php echo $telephone; ?>
										</div>
										<?php if ($order_type === '1' AND $addresses) { ?>
											<div class="form-group">
												<label for=""><?php echo lang('label_address'); ?></label><br />
												<?php foreach ($addresses as $address) { ?>
													<?php if (!empty($address['address_id']) AND $address_id == $address['address_id']) { ?>
														<address class="text-left"><?php echo $address['address']; ?></address>
													<?php } ?>
												<?php } ?>
											</div>
										<?php } ?>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for=""><?php echo lang('label_order_type'); ?></label><br /><?php echo ($order_type === '1') ? lang('label_delivery') : lang('label_collection'); ?>
										</div>
										<div class="form-group">
											<label for=""><?php echo sprintf(lang('label_order_time'), $order_type_text); ?></label><br /><?php echo mdate(lang('text_date_format') .' '. config_item('time_format'), strtotime($order_time)); ?>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6 form-group">
										<label for=""><?php echo lang('label_payment_method'); ?></label><br />
										<div class="list-group">
											<?php foreach ($payments as $payment) { ?>
												<?php if (!empty($payment['data'])) { ?>
													<div class="list-group-item"><?php echo $payment['data']; ?></div>
												<?php } ?>
											<?php } ?>
										</div>
										<?php echo form_error('payment', '<span class="text-danger">', '</span>'); ?>
									</div>

									<?php if ($checkout_terms) {?>
										<div class="col-sm-12 form-group">
											<div class="input-group">
												<span class="input-group-addon button-checkbox">
													<button type="button" class="btn" data-color="info" tabindex="7">&nbsp;&nbsp;<?php echo lang('button_agree_terms'); ?></button>
													<input type="checkbox" name="terms_condition" id="terms-condition" class="hidden" value="1" <?php echo set_checkbox('terms_condition', '1'); ?>>
												</span>
												<span class="form-control"><?php echo sprintf(lang('label_terms'), $checkout_terms); ?></span>
											</div>
											<?php echo form_error('terms_condition', '<span class="text-danger col-xs-12">', '</span>'); ?>
										</div>
										<div class="modal fade" id="terms-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-body">
													</div>
												</div>
											</div>
										</div>
									<?php } ?>

									<div class="col-sm-12 form-group">
										<label for=""><?php echo lang('label_ip'); ?></label>
										<?php echo $ip_address; ?><br /><small><?php echo lang('text_ip_warning'); ?></small>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php echo get_partial('content_right', 'col-sm-4 col-md-3'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$("#choose-order-time select.form-control").select2({
		minimumResultsForSearch: Infinity
	});

	$('input[name="order_time_type"]').on('change', function() {
		$('#choose-order-time').fadeOut();

		if (this.value === 'later') {
			$('#choose-order-time').fadeIn();
		}
	});

	$('select[name="order_date"]').on('change', function() {
		$('#choose-order-time .time-input-addon .input-group').css("display", "none");

		var timeAddonId = "#order-time-" + this.value;
		if ($(timeAddonId).length) {
			$(timeAddonId).css("display", "table");
			$(timeAddonId + ' select.hours, ' + timeAddonId + ' select.minutes:not(.hide)').trigger("change");
		}
	});

	$('select.hours').on('change', function() {
		var minutesAddonId = ".minutes-for-" + this.value;

		$('#choose-order-time .time-input-addon .minutes').addClass("hide");
		$('input[name="order_hour"]').val(this.value);

		if ($(this).parent().find(minutesAddonId).length) {
			$(minutesAddonId).removeClass("hide");
			$(minutesAddonId).css("display", "table-cell");
			$(minutesAddonId).trigger("change");
		}
	});

	$('select.minutes').on('change', function() {
		$('input[name="order_minute"]').val(this.value);
	});

	$('#address-labels input[name="address_id"]').on('change', function() {
		var formToggle = $(this).parent().parent().find('.edit-address');
		formToggle.text('<?php echo lang('text_edit'); ?>');
		$('#address-forms > div').slideUp();
	});


	$('#address-labels .edit-address').on('click', function() {
		var formDiv = $(this).attr('data-form');
		$('#address-forms > div').slideUp();

		if ($(formDiv).is(':visible')) {
			$(this).text('<?php echo lang('text_edit'); ?>');
			$(formDiv).slideUp();
		} else {
			$(this).text('<?php echo lang('text_close'); ?>');
			$(formDiv).slideDown();
		}
	});

	$('.step-one.link a').on('click', function() {
		$(this).removeClass('link');
		$('.step-two').removeClass('active').addClass('disabled');
		$('.step-one').addClass('active');
		$('input[name="checkout_step"]').val('one');
		$('#checkout').fadeIn();
		$('#payment').fadeOut();
		$('#cart-box .btn-order').text('<?php echo lang('button_payment'); ?>');

	});
});
//--></script>
<?php echo get_footer(); ?>