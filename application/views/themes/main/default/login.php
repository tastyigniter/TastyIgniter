<?php echo $header; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>

<div id="notification" class="row">
<?php if (!empty($alert)) { ?>
	<div class="alert alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $alert; ?>
	</div>
<?php } ?>
</div>
<div class="row content">
	<div class="col-md-8 wrap-all pull-left">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><?php echo $text_register; ?></h3></div>
			<div id="register" class="panel-body"></div>
		</div>
	</div>

	<div class="col-md-4 wrap-all pull-right">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><?php echo $text_login; ?></h3></div>
			<div class="panel-body">
				<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
					<div class="form-group">
						<label for="login-email"><?php echo $entry_email; ?></label>
						<input type="text" name="email" id="login-email" class="form-control" />
						<?php echo form_error('email', '<span class="error help-block">', '</span>'); ?>
					</div>
			
					<div class="form-group">
						<label for="login-password"><?php echo $entry_password; ?></label>
						<input type="password" name="password" id="login-password" class="form-control" />
						<?php echo form_error('password', '<span class="error help-block">', '</span>'); ?>
					</div>
			
					<div class="form-group">
						<a href="<?php echo $reset_url; ?>"><?php echo $text_forgot; ?></a>
					</div>
			
					<div class="buttons">
						<button type="submit" class="btn btn-success"><?php echo $button_login; ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#register').load('<?php echo site_url("main/register"); ?> .register-box > *', function() {
		$('select.form-control').selectpicker({iconBase:'fa', tickIcon:'fa-check'});
	});
});
//--></script>
<?php echo $footer; ?>