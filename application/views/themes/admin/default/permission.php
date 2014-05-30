<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
		<p align="center">&nbsp;</p>
		<h4 align="center">You do not have the right permission to access.</h4>
		<p align="center"></p>
	</div>
</div>