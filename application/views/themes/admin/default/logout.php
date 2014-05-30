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
		<h4 align="center">You have been logged out.</h4>
		<p style="text-align:center;"><a href="<?php echo base_url('admin/login'); ?>">Click Here</a> to Login</p>
	</div>
</div>