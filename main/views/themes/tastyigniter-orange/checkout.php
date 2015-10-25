<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="container top-spacing">
		<div class="row">
			<?php echo get_partial('content_left'); ?>
			<?php
				if (partial_exists('content_left') AND partial_exists('content_right')) {
					$class = "col-sm-6 col-md-6";
				} else if (partial_exists('content_left') OR partial_exists('content_right')) {
					$class = "col-sm-9 col-md-9";
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
									<p class="list-group-item-text"><?php echo lang('text_step_one_summary'); ?></p>
								</a>
							</li>
							<li class="step-two <?php echo ($checkout_step === 'two') ? 'active' : 'disabled'; ?>">
								<a>
									<h4 class="list-group-item-heading"><?php echo lang('text_step_two'); ?></h4>
									<p class="list-group-item-text"><?php echo lang('text_step_two_summary'); ?></p>
								</a>
							</li>
							<li class="step-three disabled">
								<a>
									<h4 class="list-group-item-heading"><?php echo lang('text_step_three'); ?></h4>
									<p class="list-group-item-text"><?php echo lang('text_step_three_summary'); ?></p>
								</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">

						<form method="POST" accept-charset="utf-8" action="<?php echo $_action; ?>" id="checkout-form" role="form">
                            <input type="hidden" name="checkout_step" class="checkout_step" value="<?php echo set_value('checkout_step', $checkout_step); ?>">

							<div id="checkout" style="display: <?php echo ($checkout_step === 'one') ? 'block' : 'none'; ?>">
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
											<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" />
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
											<label for="order-time"><?php echo lang('label_order_time'); ?></label>
                                            <?php if ($delivery_times) { ?>
                                                <select name="order_time" id="order-time" class="form-control">
                                                    <option value="<?php echo $asap_time; ?>"><?php echo lang('text_asap'); ?></option>
                                                    <?php foreach ($delivery_times as $key => $value) { ?>
                                                        <?php if ($key === $order_time) { ?>
                                                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            <?php } else { ?>
                                                <br /><?php echo lang('text_location_closed'); ?>
                                            <?php } ?>
                                            <?php echo form_error('order_time', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
                               </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for=""><?php echo lang('label_order_type'); ?></label><br />
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-default col-xs-6 <?php if ($order_type === '1') echo 'active btn-primary'; ?>" data-btn="btn-primary">
                                                <input type="radio" name="order_type" value="1" <?php if ($order_type === '1') echo 'checked="checked"'; ?> /> <?php echo lang('label_delivery'); ?>
                                            </label>
                                            <label class="btn btn-default col-xs-6 <?php if ($order_type === '2') echo 'active btn-primary'; ?>" data-btn="btn-primary">
                                                <input type="radio" name="order_type" value="2" <?php if ($order_type === '2') echo 'checked="checked"'; ?>/> <?php echo lang('label_collection'); ?>
                                            </label>
                                        </div>
                                        <br />
                                        <?php echo form_error('order_type', '<span class="text-danger">', '</span>'); ?>
                                        <br /><br />
                                    </div>
                                </div>

                                <?php if ($addresses) { ?>
                                    <div id="checkout-delivery" class="row wrap-bottom">
                                        <?php $address_row = 0; ?>
                                        <div id="address-labels">
                                            <div class="btn-group btn-group-md col-xs-12" data-toggle="buttons">
                                                <?php foreach ($addresses as $address) { ?>
                                                    <?php if (!empty($address['address_id'])) { ?>
                                                        <label class="btn btn-default wrap-all col-xs-3 <?php echo ($address_id == $address['address_id']) ? 'active' : ''; ?>">
                                                            <a class="edit-address pull-right" data-form="#address-form-<?php echo $address_row; ?>"><?php echo lang('text_edit'); ?></a>
                                                            <input type="radio" name="address_id" value="<?php echo $address['address_id']; ?>" <?php echo ($address['address_id'] == $address_id) ? 'checked="checked"' : ''; ?> />
                                                            <address class="text-left"><?php echo $address['address']; ?></address>
                                                        </label>
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

							<div id="payment" style="display: <?php echo ($checkout_step === 'two') ? 'block' : 'none'; ?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""><?php echo lang('label_customer_name'); ?></label><br /><?php echo $email; ?>
                                        </div>
                                        <?php if ($addresses) { ?>
                                            <div class="form-group">
                                                <label for=""><?php echo lang('label_address'); ?></label><br />
                                                <?php foreach ($addresses as $address) { ?>
                                                    <?php if (!empty($address['address_id']) AND $address_id == $address['address_id']) { ?>
                                                        <address class="text-left"><?php echo $address['address']; ?></address>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for=""><?php echo lang('label_telephone'); ?></label><br />
                                            <?php echo $telephone; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""><?php echo lang('label_order_type'); ?></label><br /><?php echo ($order_type === '1') ? lang('label_delivery') : lang('label_collection'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo lang('label_order_time'); ?></label><br /><?php echo mdate(config_item('time_format'), strtotime($order_time)); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
									<div class="col-sm-12 form-group">
										<label for=""><?php echo lang('label_payment_method'); ?></label><br />
										<?php foreach ($payments as $payment) { ?>
                                            <?php if (!empty($payment['data'])) { ?>
                                                <?php echo $payment['data']; ?>
                                            <?php } ?>
										<?php } ?>
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
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
  	$('input[name="order_type"]').on('change', function() {
  		if (this.value === '1') {
     		$('#checkout-delivery').fadeIn();
		} else {
   			$('#checkout-delivery').fadeOut();
		}
	});

  	$('#address-labels .edit-address').on('click', function() {
        var formDiv = $(this).attr('data-form');
        $('#address-forms > div').fadeOut();

        if ($(formDiv).is(':visible')) {
            $(this).text('Edit');
            $(formDiv).slideUp();
        } else {
            $(this).text('Close');
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
        $('.side-bar .buttons .btn').text('<?php echo lang('button_payment'); ?>');

    });
//    $('input[name="order_type"]:checked').trigger('change');
});
//--></script>
<?php echo get_footer(); ?>