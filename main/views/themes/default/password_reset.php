<?php echo $header; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div id="notification" class="row">
	<?php echo $this->alert->display(); ?>
</div>
<div class="row">
	<div class="col-xs-4 wrap-all">
		<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
			<div class="form-group">
				<label for="email">Email:</label>
				<input name="email" type="text" id="email" class="form-control" value="<?php echo set_value('email'); ?>" />
    			<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?></td>
			</div>
			<div class="form-group">
				<label for="security-question">Your Security Question:</label>
				<select name="security_question" id="security-question" class="form-control">
				<?php foreach ($questions as $question) { ?>
					<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
				<?php } ?>
				</select>
				<?php echo form_error('security_question', '<span class="text-danger">', '</span>'); ?>
			</div>
			<div class="form-group">
				<label for="security-answer"><?php echo $entry_s_answer; ?></label>
				<input type="text" name="security_answer" id="security-answer" class="form-control" />
				<?php echo form_error('security_answer', '<span class="text-danger">', '</span>'); ?>
			</div>

			<div class="buttons">
				<button type="submit" class="btn btn-success"><?php echo $button_reset_password; ?></button>
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>