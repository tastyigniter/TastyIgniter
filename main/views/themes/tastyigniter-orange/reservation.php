<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="container top-spacing-10">
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

			<div class="<?php echo $class; ?>">
				<div class="content-wrap">
					<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="reservation-form" role="form">
	                    <p><?php echo $text_login_register; ?></p>

	                    <div class="row">
	                        <div class="col-xs-12 col-sm-6 col-md-6">
	                            <div class="form-group">
	                                <input type="text" name="first_name" id="first-name" class="form-control" placeholder="<?php echo lang('label_first_name'); ?>" value="<?php echo set_value('first_name', $first_name); ?>" />
	                                <?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
	                            </div>
	                        </div>

	                        <div class="col-xs-12 col-sm-6 col-md-6">
	                            <div class="form-group">
	                                <input type="text" name="last_name" id="last-name" class="form-control" placeholder="<?php echo lang('label_last_name'); ?>" value="<?php echo set_value('last_name', $last_name); ?>" />
	                                <?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="row">
	                        <div class="col-xs-12 col-sm-6 col-md-6">
	                            <div class="form-group">
	                                <input type="text" name="email" id="email" class="form-control" placeholder="<?php echo lang('label_email'); ?>" value="<?php echo set_value('email', $email); ?>" />
	                                <?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
	                            </div>
	                        </div>

	                        <div class="col-xs-12 col-sm-6 col-md-6">
	                            <div class="form-group">
	                                <input type="text" name="confirm_email" id="confirm-email" class="form-control" placeholder="<?php echo lang('label_confirm_email'); ?>" value="<?php echo set_value('confirm_email', $email); ?>" />
	                                <?php echo form_error('confirm_email', '<span class="text-danger">', '</span>'); ?>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <input type="text" name="telephone" id="telephone" class="form-control" placeholder="<?php echo lang('label_telephone'); ?>" value="<?php echo set_value('telephone', $telephone); ?>" />
	                        <?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
	                    </div>

	                    <div class="form-group">
	                        <textarea name="comment" id="comment" class="form-control" rows="2" placeholder="<?php echo lang('label_comment'); ?>"><?php echo set_value('comment', $comment); ?></textarea>
	                        <?php echo form_error('comment', '<span class="text-danger">', '</span>'); ?>
	                    </div>

	                    <div class="form-group">
	                        <div class="input-group">
	                            <span><?php echo $captcha['image']; ?></span>
	                            <input type="hidden" name="captcha_word" class="form-control" value="<?php echo $captcha['word']; ?>" />
	                            <input type="text" name="captcha" class="form-control" placeholder="<?php echo lang('label_captcha'); ?>" />
	                        </div>
	                        <?php echo form_error('captcha', '<span class="text-danger">', '</span>'); ?>
	                    </div>

	                    <?php if ($find_table_action === 'view_summary') { ?>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <button type="submit" class="btn btn-primary btn-block btn-lg"><?php echo lang('button_reservation'); ?></button>
	                            </div>
	                            <div class="col-sm-2">
	                                <a class="btn btn-default btn-lg text-muted" href="<?php echo $reset_url; ?>"><?php echo lang('button_find_again'); ?></a>
	                            </div>
	                        </div>
	                    <?php } ?>
	                </form>
				</div>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>