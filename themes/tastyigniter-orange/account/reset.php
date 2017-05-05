<?php echo get_header(); ?>

<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h3><?php echo lang('text_heading'); ?></h3>
					<span class="under-heading"></span>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="content-wrap col-md-6 center-block">
				<?php if ($this->alert->get('', 'alert')) { ?>
					<div id="notification">
						<?php echo $this->alert->display('', 'alert'); ?>
					</div>
				<?php } ?>
				<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
                    <?php if (!empty($reset_code)) { ?>
                        <div class="form-group">
                            <input type="password" id="password" class="form-control input-lg" name="password" placeholder="<?php echo lang('label_password'); ?>">
                            <?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password-confirm" class="form-control input-lg" name="password_confirm" placeholder="<?php echo lang('label_password_confirm'); ?>">
                            <?php echo form_error('password_confirm', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    <?php } else { ?>
                        <p class="text-center"><?php echo lang('text_summary'); ?></p>
                        <div class="form-group">
                            <input name="email" type="text" id="email" class="form-control input-lg" value="<?php echo set_value('email'); ?>" placeholder="<?php echo lang('label_email'); ?>" />
                            <?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    <?php } ?>
					<div class="row text-center">
						<div class="col-xs-12 col-md-6">
							<button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo lang('button_reset'); ?></button>
						</div>
						<div class="col-xs-12 col-md-6">
							<a class="btn btn-default btn-lg btn-block" href="<?php echo $login_url; ?>"><?php echo lang('button_login'); ?></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>