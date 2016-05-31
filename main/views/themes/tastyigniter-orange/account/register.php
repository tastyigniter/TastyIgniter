<?php echo get_header(); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h3><?php echo lang('text_register'); ?></h3>
					<span class="under-heading"></span>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div id="register-form" class="content-wrap col-sm-6 center-block">
					<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form" class="">
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="text" id="first-name" class="form-control input-lg" value="<?php echo set_value('first_name'); ?>" name="first_name" placeholder="<?php echo lang('label_first_name'); ?>" autofocus="">
									<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="text" id="last-name" class="form-control input-lg" value="<?php echo set_value('last_name'); ?>" name="last_name" placeholder="<?php echo lang('label_last_name'); ?>">
									<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<input type="text" id="email" class="form-control input-lg" value="<?php echo set_value('email'); ?>" name="email" placeholder="<?php echo lang('label_email'); ?>">
							<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="password" id="password" class="form-control input-lg" value="" name="password" placeholder="<?php echo lang('label_password'); ?>">
									<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="password" id="password-confirm" class="form-control input-lg" name="password_confirm" value="" placeholder="<?php echo lang('label_password_confirm'); ?>">
									<?php echo form_error('password_confirm', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<input type="text" id="telephone" class="form-control input-lg" value="<?php echo set_value('telephone'); ?>" name="telephone" placeholder="<?php echo lang('label_telephone'); ?>">
							<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
						</div>
						<div class="form-group">
							<select name="security_question" id="security-question" class="form-control input-lg" placeholder="<?php echo lang('label_s_question'); ?>">
							<?php foreach ($questions as $question) { ?>
								<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
							<?php } ?>
							</select>
							<?php echo form_error('security_question', '<span class="text-danger">', '</span>'); ?>
						</div>
						<div class="form-group">
							<input type="text" id="security-answer" class="form-control input-lg" name="security_answer" value="<?php echo set_value('security_answer'); ?>" placeholder="<?php echo lang('label_s_answer'); ?>">
							<?php echo form_error('security_answer', '<span class="text-danger">', '</span>'); ?>
						</div>
						<div class="form-group">
							<div class="input-group">
         		 				<span><?php echo $captcha['image']; ?></span>
								<input type="hidden" name="captcha_word" class="form-control" value="<?php echo $captcha['word']; ?>" />
								<input type="text" name="captcha" class="form-control" placeholder="<?php echo lang('label_captcha'); ?>" />
							</div>
							<?php echo form_error('captcha', '<span class="text-danger">', '</span>'); ?>
						</div>
						<div class="row">
							<div class="col-xs-8 col-sm-9 col-md-9">
								<span class="button-checkbox">
									<button id="newsletter" type="button" class="btn" data-color="info" tabindex="7">&nbsp;&nbsp<?php echo lang('button_subscribe'); ?></button>
			                        <input type="checkbox" name="newsletter" class="hidden" value="1" <?php echo set_checkbox('newsletter', '1'); ?>>
								</span>
								 <?php echo lang('label_newsletter'); ?>
							</div>
							<?php echo form_error('newsletter', '<span class="text-danger">', '</span>'); ?>
						</div>
						<br />

						<?php if ($registration_terms) {?>
							<div class="row">
								<div class="col-xs-8 col-sm-9 col-md-9">
									<span class="button-checkbox">
										<button id="terms-condition" type="button" class="btn" data-color="info" tabindex="7">&nbsp;&nbsp;<?php echo lang('button_terms_agree'); ?></button>
				                        <input type="checkbox" name="terms_condition" class="hidden" value="1" <?php echo set_checkbox('terms_condition', '1'); ?>>
									</span>
									<?php echo sprintf(lang('label_terms'), $registration_terms); ?>
								</div>
								<?php echo form_error('terms_condition', '<span class="text-danger">', '</span>'); ?>
							</div>
							<div class="modal fade" id="terms-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-body">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<br />
						<br />

						<div class="row">
							<div class="col-xs-12 col-md-6">
								<button type="submit" class="btn btn-primary btn-block btn-lg"><?php echo lang('button_register'); ?></button>
							</div>
							<div class="col-xs-12 col-md-6">
								<a href="<?php echo $login_url; ?>" class="btn btn-default btn-block btn-lg"><?php echo lang('button_login'); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>