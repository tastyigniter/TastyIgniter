<?php echo $header; ?>
<?php
	if (!empty($extension_name)) {
		echo $this->extension->options($extension_name, $extension_options);
	}
?>
<?php echo $footer; ?>