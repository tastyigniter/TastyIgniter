<div class="content">
<div class="wrap">
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="payment-form">
	<div>
	<table border="0" cellpadding="2" width="100%" id="payment-method" class="form">
		<tr>
			<td colspan="2"><h2><?php echo $text_payments; ?></h2></td>
		</tr>
		<tr>
			<td align="right"><b><?php echo $entry_payment_method; ?></b></td>
			<td>
				<?php if ($this->config->item('cod_status') === '1') { ?>
					<input type="radio" name="payment" value="cod" <?php echo set_radio('payment', 'cod'); ?> /><?php echo $text_cod; ?><br />
				<?php } ?>

				<?php if ($this->config->item('paypal_status') === '1') { ?>
					<input type="radio" name="payment" value="paypal" <?php echo set_radio('payment', 'paypal'); ?> /><?php echo $text_paypal; ?><br />
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
