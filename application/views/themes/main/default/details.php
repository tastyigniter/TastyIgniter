<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_details; ?></h3></div>

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

	<div class="col-md-8 page-content">
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
		<div class="row wrap-all">
			<div class="form-group">
				<td align="right"><label for="first-name"><?php echo $entry_first_name; ?></label></td>
				<td><input type="text" name="first_name" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
					<?php echo form_error('first_name', '<span class="error help-block">', '</span>'); ?>
				</td>
			</div>
			<div class="form-group">
				<td align="right"><label for="last-name"><?php echo $entry_last_name; ?></label></td>
				<td><input type="text" name="last_name" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" />
					<?php echo form_error('last_name', '<span class="error help-block">', '</span>'); ?>
				</td>
			</div>
			<div class="form-group">
				<td align="right"><label for="email"><?php echo $entry_email; ?></label></td>
				<td><input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>" disabled /></td>
			</div>
			<div class="form-group">
				<td align="right"><label for="telephone"><?php echo $entry_telephone; ?></label></td>
				<td><input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo set_value('telephone', $telephone); ?>" />
					<?php echo form_error('telephone', '<span class="error help-block">', '</span>'); ?>
				</td>
			</div>
			<div class="form-group">
				<td align="right"><label for="question"><?php echo $entry_s_question; ?></label></td>
				<td><select name="security_question" id="question" class="form-control">
				<option value=""><?php echo $text_select; ?></option>
				<?php foreach ($questions as $question) { ?>
				<?php if ($question['question_id'] === $security_question) { ?>
					<option value="<?php echo $question['question_id']; ?>" selected="selected"><?php echo $question['text']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $question['question_id']; ?>"><?php echo $question['text']; ?></option>
				<?php } ?>
				<?php } ?>
				</select>
					<?php echo form_error('security_question', '<span class="error help-block">', '</span>'); ?>
				</td>
			</div>
			<div class="form-group">
				<td align="right"><label for="answer"><?php echo $entry_s_answer; ?></label></td>
				<td><input type="text" name="security_answer" id="answer" class="form-control" value="<?php echo set_value('security_answer', $security_answer); ?>" />
					<?php echo form_error('security_answer', '<span class="error help-block">', '</span>'); ?>
				</td>
			</div>

			<h3><?php echo $text_password; ?></h3>

			<div class="form-group">
				<td align="right"><label for="old-password"><?php echo $entry_old_password; ?></label></td>
				<td><input type="password" name="old_password" id="old-password" class="form-control" value="" />
					<?php echo form_error('old_password', '<span class="error help-block">', '</span>'); ?>
				</td>
			</div>
			<div class="form-group">
				<td align="right"><label for="new-password"><?php echo $entry_password; ?></label></td>
				<td><input type="password" name="new_password" id="new-password" class="form-control" value="" />
					<?php echo form_error('new_password', '<span class="error help-block">', '</span>'); ?>
				</td>
			</div>
			<div class="form-group">
				<td align="right"><label for="cnew-password"><?php echo $entry_password_confirm; ?></label></td>
				<td><input type="password" name="confirm_new_password" id="cnew-password" class="form-control" value="" />
					<?php echo form_error('confirm_new_password', '<span class="error help-block">', '</span>'); ?>
				</td>
			</div>
		</div>

		<div class="row wrap-all">
			<div class="buttons">
				<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
				<button type="submit" class="btn btn-success"><?php echo $button_save; ?></button>
			</div>
		</div>
	</form>
	</div>
</div>
<?php echo $footer; ?>