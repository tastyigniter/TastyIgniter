<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
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
					<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
						<div class="col-md-12">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" name="first_name" placeholder="<?php echo $entry_first_name; ?>">
										<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" name="last_name" placeholder="<?php echo $entry_last_name; ?>">
										<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<input type="text" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" name="email" placeholder="<?php echo $entry_email; ?>" disabled>
								<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
							</div>
							<div class="form-group">
								<input type="text" id="telephone" class="form-control" value="<?php echo set_value('telephone', $telephone); ?>" name="telephone" placeholder="<?php echo $entry_telephone; ?>">
								<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
							</div>
							<div class="form-group">
								<select name="security_question" id="security-question" class="form-control" placeholder="<?php echo $entry_s_question; ?>">
									<?php foreach ($questions as $question) { ?>
										<?php if ($question['question_id'] === $security_question) { ?>
											<option value="<?php echo $question['question_id']; ?>" selected="selected"><?php echo $question['text']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $question['question_id']; ?>"><?php echo $question['text']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
								<?php echo form_error('security_question', '<span class="text-danger">', '</span>'); ?>
							</div>
							<div class="form-group">
								<input type="text" id="security-answer" class="form-control" name="security_answer" value="<?php echo set_value('security_answer', $security_answer); ?>" placeholder="<?php echo $entry_s_answer; ?>">
								<?php echo form_error('security_answer', '<span class="text-danger">', '</span>'); ?>
							</div>
							<div class="row">
								<div class="col-xs-3 col-sm-2 col-md-2">
									<span class="button-checkbox">
										<button type="button" class="btn" data-color="info" tabindex="7">&nbsp;&nbsp;Subscribe</button>
				                        <input type="checkbox" name="newsletter" id="newsletter" class="hidden" value="1" <?php echo set_checkbox('newsletter', $newsletter); ?>>
									</span>
								</div>
								<div class="col-xs-9 col-sm-10 col-md-10">
									 <label for="first-name" class="control-label text-muted"><?php echo $entry_newsletter; ?></label>
								</div>
								<?php echo form_error('newsletter', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="heading-section">
								<h2><?php echo $text_password; ?></h2>
								<span class="under-heading"></span>
							</div>

							<div class="form-group">
								<input type="password" name="old_password" id="old-password" class="form-control" value="" placeholder="<?php echo $entry_old_password; ?>" />
								<?php echo form_error('old_password', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="password" id="new-password" class="form-control" value="" name="new_password" placeholder="<?php echo $entry_password; ?>">
										<?php echo form_error('new_password', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="password" id="cnew-password" class="form-control" name="confirm_new_password" value="" placeholder="<?php echo $entry_password_confirm; ?>">
										<?php echo form_error('confirm_new_password', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<br />
							<div class="buttons">
								<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
								<button type="submit" class="btn btn-success"><?php echo $button_save; ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php echo $content_right; ?>
			<?php echo $content_bottom; ?>
		</div>
	</div>
</div>
<?php echo $footer; ?>