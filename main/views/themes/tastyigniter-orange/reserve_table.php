<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="page-content">
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<p class="text-muted well"><?php echo $text_login_register; ?></p>
                    <span class="under-heading"></span>
				</div>
			</div>
		</div>

		<div class="row">
			<?php echo $content_left; ?>
			<?php
				if (!empty($content_left) AND !empty($content_right)) {
					$class = "col-sm-6 col-md-6";
				} else if (!empty($content_left) OR !empty($content_right)) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="<?php echo $class; ?>">
				<div class="row">
					<div class="col-md-12">
						<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="reserve-form" role="form">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<label for="first-name"><?php echo $entry_first_name; ?></label>
										<input type="text" name="first_name" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
										<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<label for="last-name"><?php echo $entry_last_name; ?></label>
										<input type="text" name="last_name" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" />
										<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<label for="email"><?php echo $entry_email; ?></label>
										<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" />
										<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<label for="confirm-email"><?php echo $entry_confirm_email; ?></label>
										<input type="text" name="confirm_email" id="confirm-email" class="form-control" value="<?php echo set_value('confirm_email'); ?>" />
										<?php echo form_error('confirm_email', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="telephone"><?php echo $entry_telephone; ?></label>
								<input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo set_value('telephone', $telephone); ?>" />
								<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="form-group">
								<label for="comment"><?php echo $entry_comments; ?></label>
								<textarea name="comment" id="comment" class="form-control" rows="5"><?php echo set_value('comment', $comment); ?></textarea>
								<?php echo form_error('comment', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="form-group">
								<div class="input-group">
				 				<span><?php echo $captcha_image; ?></span>
									<input type="text" name="captcha" class="form-control" placeholder="<?php echo $entry_captcha; ?>" />
								</div>
								<?php echo form_error('captcha', '<span class="text-danger">', '</span>'); ?>
							</div>

							<?php if ($show_reserve) { ?>
								<div class="row">
									<div class="buttons col-sm-6">
										<a class="btn btn-success btn-lg" onclick="$('#find-table-form, #reserve-form').submit();"><?php echo $button_reservation; ?></a>
									</div>
								</div>
							<?php } ?>

						</form>
					</div>
				</div>
			</div>
			<?php echo $content_right; ?>
			<?php echo $content_bottom; ?>
		</div>
	</div>
</div>
<?php echo $footer; ?>