<div class="radio">
	<label>
        <?php if ($minimum_order_total >= $order_total) { ?>
            <input type="radio" name="payment" value="" <?php echo set_radio('payment', ''); ?> disabled />
        <?php } else if ($payment === $code) { ?>
            <input type="radio" name="payment" value="<?php echo $code; ?>" <?php echo set_radio('payment', $code, TRUE); ?> />
        <?php } else { ?>
            <input type="radio" name="payment" value="<?php echo $code; ?>" <?php echo set_radio('payment', $code); ?> />
        <?php } ?>
        <?php echo $title; ?> - <span><?php echo $description; ?></span>
    </label>
    <?php if ($minimum_order_total >= $order_total) { ?>
        <br /><span class="text-info"><?php echo sprintf(lang('alert_min_order_total'), currency_format($minimum_order_total)); ?></span>
    <?php } ?>
</div>
<div id="stripe-payment" class="wrap-horizontal" style="<?php echo ($payment === 'authorize_net_aim') ? 'display: block;' : 'display: none;'; ?>">
	<?php if (!empty($stripe_token)) { ?>
		<input type="hidden" name="stripe_token" value="<?php echo $stripe_token; ?>" />
	<?php } ?>

	<div class="row">
	    <div class="col-xs-12">
			<div class="stripe-errors"></div>
		</div>
	</div>
	<div class="row">
	    <div class="col-xs-12">
	        <div class="form-group">
	            <label for="input-card-number"><?php echo lang('label_card_number'); ?></label>
	            <div class="input-group">
	                <input type="text" id="input-card-number" class="form-control" name="stripe_cc_number" value="<?php echo set_value('stripe_cc_number', $stripe_cc_number); ?>" placeholder="<?php echo lang('text_cc_number'); ?>" autocomplete="cc-number" size="20" data-stripe="number" required />
	                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
	            </div>
		        <?php echo form_error('stripe_cc_number', '<span class="text-danger">', '</span>'); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-xs-7 col-md-7">
	        <div class="form-group">
	            <label for="input-expiry-month"><?php echo lang('label_card_expiry'); ?></label>
	            <div class="row">
	                <div class="col-xs-6 col-lg-6">
				        <input type="tel" class="form-control" id="input-expiry-month" name="stripe_cc_exp_month" value="<?php echo set_value('stripe_cc_exp_month', $stripe_cc_exp_month); ?>" placeholder="<?php echo lang('text_exp_month'); ?>" autocomplete="off" size="2" data-stripe="exp-month" required data-numeric />
			        </div>
			        <div class="col-xs-6 col-lg-6">
				        <input type="tel" class="form-control" id="input-expiry-year" name="stripe_cc_exp_year" value="<?php echo set_value('stripe_cc_exp_year', $stripe_cc_exp_year); ?>" placeholder="<?php echo lang('text_exp_year'); ?>" autocomplete="off" size="4" data-stripe="exp-year" required data-numeric />
			        </div>
		        </div>
		        <?php echo form_error('stripe_cc_exp_month', '<span class="text-danger">', '</span>'); ?>
		        <?php echo form_error('stripe_cc_exp_year', '<span class="text-danger">', '</span>'); ?>
	        </div>
	    </div>
	    <div class="col-xs-5 col-md-5 pull-right">
	        <div class="form-group">
	            <label for="input-card-cvc"><?php echo lang('label_card_cvc'); ?></label>
	            <input type="tel" class="form-control" name="stripe_cc_cvc" value="<?php echo set_value('stripe_cc_cvc', $stripe_cc_cvc); ?>" placeholder="<?php echo lang('text_cc_cvc'); ?>" autocomplete="off" size="4" data-stripe="cvc" required />
		        <?php echo form_error('stripe_cc_cvc', '<span class="text-danger">', '</span>'); ?>
	        </div>
	    </div>
	</div>
</div>
<script type="text/javascript"><!--
	var forceSSL = "<?php echo $force_ssl; ?>";
	$(document).ready(function() {
		$('input[name="payment"]').on('change', function () {
			if (this.value === 'stripe') {
				if (forceSSL == '1' && location.href.indexOf("https://") == -1) {
					location.href = location.href.replace("http://", "https://");
				}

				$('#stripe-payment').slideDown();
			} else {
				$('#stripe-payment').slideUp();
			}
		});

		$('input[name="payment"]:checked').trigger('change');
	});
--></script>
