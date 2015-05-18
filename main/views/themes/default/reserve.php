<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="container">
<div class="row">
	<?php echo get_partial('content_left'); ?><?php echo get_partial('content_right'); ?>

	<div class="col-md-8 wrap-all">
		<p class="text-info well"><?php echo $text_login_register; ?></p>

		<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="reserve-form" role="form">
			<div class="form-group">
				<label for="first-name"><?php echo $entry_first_name; ?></label>
				<input type="text" name="first_name" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
				<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
			</div>

			<div class="form-group">
				<label for="last-name"><?php echo $entry_last_name; ?></label>
				<input type="text" name="last_name" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" />
				<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
			</div>

			<div class="form-group">
				<label for="email"><?php echo $entry_email; ?></label>
				<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" />
				<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
			</div>

			<div class="form-group">
				<label for="confirm-email"><?php echo $entry_confirm_email; ?></label>
				<input type="text" name="confirm_email" id="confirm-email" class="form-control" value="<?php echo set_value('confirm_email'); ?>" />
				<?php echo form_error('confirm_email', '<span class="text-danger">', '</span>'); ?>
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
		</table>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>