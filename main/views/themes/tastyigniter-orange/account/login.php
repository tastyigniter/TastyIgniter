<?php echo get_header(); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h3><?php echo $text_login; ?></h3>
					<span class="under-heading"></span>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div id="login-form" class="col-sm-6 center-block">
					<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
						<fieldset>
							<div class="form-group">
								<div class="input-group">
									<input type="text" name="email" id="login-email" class="form-control input-lg" placeholder="<?php echo $entry_email; ?>" autofocus="" />
	         		 				<span class="input-group-addon">@</span>
								</div>
								<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="form-group">
								<div class="input-group">
									<input type="password" name="password" id="login-password" class="form-control input-lg" placeholder="<?php echo $entry_password; ?>" />
         		 					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								</div>
								<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4">
										<button type="submit" class="btn btn-success btn-block btn-lg"><?php echo $button_login; ?></button>
									</div>
									<div class="col-md-4">
										<a class="btn btn-primary btn-block btn-lg" href="<?php echo $register_url; ?>"><?php echo $button_register; ?></a>
									</div>
									<div class="col-md-4">
										<a class="pull-right text-muted" href="<?php echo $reset_url; ?>"><small><?php echo $text_forgot; ?></small></a>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
 			</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>