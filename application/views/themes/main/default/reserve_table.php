<?php echo $header; ?>
<?php echo $content_top; ?>
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
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-md-9 wrap-all">
		<p class="text-info well"><?php echo $text_login_register; ?></p>
		
		<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="reserve-form" role="form">
			<div class="form-group">
				<label for="first-name"><?php echo $entry_first_name; ?></label>
				<input type="text" name="first_name" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
				<?php echo form_error('first_name', '<span class="error help-block">', '</span>'); ?>
			</div>
				
			<div class="form-group">
				<label for="last-name"><?php echo $entry_last_name; ?></label>
				<input type="text" name="last_name" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" />
				<?php echo form_error('last_name', '<span class="error help-block">', '</span>'); ?>
			</div>
				
			<div class="form-group">
				<label for="email"><?php echo $entry_email; ?></label>
				<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" />
				<?php echo form_error('email', '<span class="error help-block">', '</span>'); ?>
			</div>
				
			<div class="form-group">
				<label for="confirm-email"><?php echo $entry_confirm_email; ?></label>
				<input type="text" name="confirm_email" id="confirm-email" class="form-control" value="<?php echo set_value('confirm_email'); ?>" />
				<?php echo form_error('confirm_email', '<span class="error help-block">', '</span>'); ?>
			</div>
				
			<div class="form-group">
				<label for="telephone"><?php echo $entry_telephone; ?></label>
				<input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo set_value('telephone', $telephone); ?>" />
				<?php echo form_error('telephone', '<span class="error help-block">', '</span>'); ?>
			</div>
				
			<div class="form-group">
				<label for="comment"><?php echo $entry_comments; ?></label>
				<textarea name="comment" id="comment" class="form-control" rows="5"><?php echo set_value('comment', $comment); ?></textarea>
				<?php echo form_error('comment', '<span class="error help-block">', '</span>'); ?>
			</div>
		</table>
		</form>
	</div>
</div>
<?php echo $footer; ?>