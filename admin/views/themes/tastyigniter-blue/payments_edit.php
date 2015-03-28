<?php echo $header; ?>
<?php
	if (!empty($payment_name)) {
		echo $this->extension->options($payment_name, $payments_options);
	}
?>
<?php echo $footer; ?>