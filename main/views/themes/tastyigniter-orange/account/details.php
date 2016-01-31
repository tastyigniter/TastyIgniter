<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>

<?php if ($this->alert->get()) { ?>
    <div id="notification">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->alert->display(); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div id="page-content">
	<div class="container top-spacing">
		<div class="row">
			<?php echo get_partial('content_left'); ?>
			<?php
				if (partial_exists('content_left') AND partial_exists('content_right')) {
					$class = "col-sm-6 col-md-6";
				} else if (partial_exists('content_left') OR partial_exists('content_right')) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="content-wrap <?php echo $class; ?>">
				<div class="row">
					<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
						<div class="col-md-12">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" name="first_name" placeholder="<?php echo lang('label_first_name'); ?>">
										<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" name="last_name" placeholder="<?php echo lang('label_last_name'); ?>">
										<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
							</div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="telephone" class="form-control" value="<?php echo set_value('telephone', $telephone); ?>" name="telephone" placeholder="<?php echo lang('label_telephone'); ?>">
                                        <?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" name="email" placeholder="<?php echo lang('label_email'); ?>" disabled>
                                        <?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
							</div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <select name="security_question_id" id="security-question" class="form-control" placeholder="<?php echo lang('label_s_question'); ?>">
                                            <?php foreach ($questions as $question) { ?>
                                                <?php if ($question['question_id'] === $security_question) { ?>
                                                    <option value="<?php echo $question['question_id']; ?>" selected="selected"><?php echo $question['text']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $question['question_id']; ?>"><?php echo $question['text']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('security_question_id', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="security-answer" class="form-control" name="security_answer" value="<?php echo set_value('security_answer', $security_answer); ?>" placeholder="<?php echo lang('label_s_answer'); ?>">
                                        <?php echo form_error('security_answer', '<span class="text-danger">', '</span>'); ?>
                                   </div>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-xs-9 col-sm-10 col-md-10">
									<span class="button-checkbox">
										<button type="button" class="btn" data-color="info" tabindex="7">&nbsp;&nbsp;<?php echo lang('button_subscribe'); ?></button>
										<?php if ($newsletter === '1') { ?>
											<input type="checkbox" name="newsletter" id="newsletter" class="hidden" value="1" <?php echo set_checkbox('newsletter', '1', TRUE); ?>>
										<?php } else { ?>
											<input type="checkbox" name="newsletter" id="newsletter" class="hidden" value="1" <?php echo set_checkbox('newsletter', '1'); ?>>
										<?php } ?>
									</span>
                                    <label for="newsletter" class="control-label text-muted"><?php echo lang('label_newsletter'); ?></label>
								</div>
								<?php echo form_error('newsletter', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="row top-spacing-20">
                                <div class="col-xs-12">
                                    <h4><?php echo lang('text_password_heading'); ?></h4>
							    </div>
							</div>

							<div class="form-group">
								<input type="password" name="old_password" id="old-password" class="form-control" value="" placeholder="<?php echo lang('label_old_password'); ?>" />
								<?php echo form_error('old_password', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="password" id="new-password" class="form-control" value="" name="new_password" placeholder="<?php echo lang('label_password'); ?>">
										<?php echo form_error('new_password', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="password" id="cnew-password" class="form-control" name="confirm_new_password" value="" placeholder="<?php echo lang('label_password_confirm'); ?>">
										<?php echo form_error('confirm_new_password', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<br />
							<div class="buttons">
								<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
								<button type="submit" class="btn btn-primary btn-lg"><?php echo lang('button_save'); ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>