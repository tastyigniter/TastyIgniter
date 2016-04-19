<div class="radio">
	<label>
        <?php if ($minimum_order_total >= $order_total) { ?>
            <input type="radio" name="payment" value="" <?php echo set_radio('payment', ''); ?> disabled />
        <?php } else if ($payment === $code) { ?>
            <input type="radio" name="payment" value="<?php echo $code; ?>" <?php echo set_radio('payment', $code, TRUE); ?> />
        <?php } else { ?>
            <input type="radio" name="payment" value="<?php echo $code; ?>" <?php echo set_radio('payment', $code); ?> />
        <?php } ?>
        <?php echo $title; ?>
    </label>
    <?php if ($minimum_order_total >= $order_total) { ?>
        <br /><span class="text-info"><?php echo sprintf(lang('alert_min_order_total'), currency_format($minimum_order_total)); ?></span>
    <?php } ?>
</div>
<div class="payment-card-icons">
	<i class="fa fa-cc-visa fa-2x"></i>
	<i class="fa fa-cc-mastercard fa-2x"></i>
	<i class="fa fa-cc-amex fa-2x"></i>
	<i class="fa fa-cc-diners-club fa-2x"></i>
	<i class="fa fa-cc-jcb fa-2x"></i>
</div>
<div id="authorize-net-aim" class="wrap-horizontal" style="<?php echo ($payment === 'authorize_net_aim') ? 'display: block;' : 'display: none;'; ?>">
	<div class="row">
	    <div class="col-xs-12">
	        <div class="form-group">
	            <label for="input-card-number"><?php echo lang('label_card_number'); ?></label>
	            <div class="input-group">
	                <input type="text" id="input-card-number" class="form-control" name="authorize_cc_number" value="<?php echo set_value('authorize_cc_number', $authorize_cc_number); ?>" placeholder="<?php echo lang('text_cc_number'); ?>" autocomplete="off" required />
	                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
	            </div>
		        <?php echo form_error('authorize_cc_number', '<span class="text-danger">', '</span>'); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-xs-7 col-md-7">
	        <div class="form-group">
	            <label for="input-expiry-month"><?php echo lang('label_card_expiry'); ?></label>
	            <div class="row">
	                <div class="col-xs-6 col-lg-6">
				        <input type="text" name="authorize_cc_exp_month" class="form-control" id="input-expiry-month" value="<?php echo set_value('authorize_cc_exp_month', $authorize_cc_exp_month); ?>" placeholder="<?php echo lang('text_exp_month'); ?>" autocomplete="off" required />
			        </div>
			        <div class="col-xs-6 col-lg-6">
				        <input type="text" name="authorize_cc_exp_year" class="form-control" id="input-expiry-year" value="<?php echo set_value('authorize_cc_exp_year', $authorize_cc_exp_year); ?>" placeholder="<?php echo lang('text_exp_year'); ?>" autocomplete="off" required />
			        </div>
		        </div>
		        <?php echo form_error('authorize_cc_exp_month', '<span class="text-danger">', '</span>'); ?>
		        <?php echo form_error('authorize_cc_exp_year', '<span class="text-danger">', '</span>'); ?>
	        </div>
	    </div>
	    <div class="col-xs-5 col-md-5 pull-right">
	        <div class="form-group">
	            <label for="input-card-cvc"><?php echo lang('label_card_cvc'); ?></label>
	            <input type="text" class="form-control" name="authorize_cc_cvc" value="<?php echo set_value('authorize_cc_cvc', $authorize_cc_cvc); ?>" placeholder="<?php echo lang('text_cc_cvc'); ?>" autocomplete="off" required />
		        <?php echo form_error('authorize_cc_cvc', '<span class="text-danger">', '</span>'); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="form-group">
				<?php if ($order_type === '1') { ?>
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" name="authorize_same_address" <?php echo set_checkbox('authorize_same_address', '1', TRUE) ?> />
						<?php echo lang('label_same_address') ?>
					</label>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div id="authorize-same-address">
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group">
					<select name="authorize_address_id" class="form-control">
						<option value="new"><?php echo lang('text_add_new_address'); ?></option>
						<?php foreach ($addresses as $address) { ?>
							<?php if ($address['address_id'] === $authorize_address_id) { ?>
								<option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['address']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $address['address_id']; ?>"><?php echo $address['address']; ?></option>
							<?php } ?>
							<?php $address_row++; ?>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div id="authorize-hide-address">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<input type="text" class="form-control" name="authorize_address_1" value="<?php echo set_value('authorize_address_1'); ?>" placeholder="<?php echo lang('label_address_1'); ?>" required />
						<?php echo form_error('authorize_address_1', '<span class="text-danger">', '</span>'); ?>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="form-group">
						<input type="text" class="form-control" name="authorize_address_2" value="<?php echo set_value('authorize_address_2'); ?>" placeholder="<?php echo lang('label_address_2'); ?>" />
						<?php echo form_error('authorize_address_2', '<span class="text-danger">', '</span>'); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<input type="text" class="form-control" name="authorize_city" value="<?php echo set_value('authorize_city'); ?>" placeholder="<?php echo lang('label_city'); ?>" />
						<?php echo form_error('authorize_city', '<span class="text-danger">', '</span>'); ?>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<input type="text" class="form-control" name="authorize_state" value="<?php echo set_value('authorize_state'); ?>" placeholder="<?php echo lang('label_state'); ?>" />
						<?php echo form_error('authorize_state', '<span class="text-danger">', '</span>'); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<input type="text" class="form-control" name="authorize_postcode" value="<?php echo set_value('authorize_postcode'); ?>" placeholder="<?php echo lang('label_postcode'); ?>" />
						<?php echo form_error('authorize_postcode', '<span class="text-danger">', '</span>'); ?>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<select name="authorize_country_id" class="form-control">
							<?php foreach ($countries as $country) { ?>
								<?php if ($country['country_id'] === $authorize_country_id) { ?>
									<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php echo form_error('authorize_country', '<span class="text-danger">', '</span>'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
	$(document).ready(function() {
		$('input[name="payment"]').on('change', function () {
			if (this.value === 'authorize_net_aim') {
				$('#authorize-net-aim').fadeIn();
			} else {
				$('#authorize-net-aim').fadeOut();
			}
		});

		$('select[name="authorize_address_id"]').on('change', function () {
			$('#authorize-hide-address').fadeOut();

			if (this.value === 'new') {
				$('#authorize-hide-address').fadeIn();
			}
		});

		$('input[name="authorize_same_address"]').on('change', function () {
			$('#authorize-same-address').fadeOut();

			if (!$(this).is(':checked')) {
				$('#authorize-same-address').fadeIn();
			}
		});

		$('input[name="payment"]:checked, select[name="authorize_address_id"], input[name="authorize_same_address"]').trigger('change');
	});
--></script>
