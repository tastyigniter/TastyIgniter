<?php echo get_header(); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h3><?php echo $text_heading; ?></h3>
					<span class="under-heading"></span>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 center-block">
				<p><?php echo $text_summary; ?></p>
				<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
					<div class="form-group">
						<input name="email" type="text" id="email" class="form-control input-lg" value="<?php echo set_value('email'); ?>" placeholder="<?php echo $entry_email; ?>" />
		    			<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?></td>
					</div>
					<div class="form-group">
						<select name="security_question" id="security-question" class="form-control input-lg">
						<?php foreach ($questions as $question) { ?>
							<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
						<?php } ?>
						</select>
						<?php echo form_error('security_question', '<span class="text-danger">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label for="security-answer"></label>
						<input type="text" name="security_answer" id="security-answer" class="form-control input-lg" placeholder="<?php echo $entry_s_answer; ?>" />
						<?php echo form_error('security_answer', '<span class="text-danger">', '</span>'); ?>
					</div>
					<br />

					<div class="row text-center">
						<div class="col-xs-12 col-md-6">
							<button type="submit" class="btn btn-success btn-lg btn-block"><?php echo $button_reset_password; ?></button>
						</div>
						<div class="col-xs-12 col-md-6">
							<a class="btn btn-primary btn-lg btn-block" href="<?php echo $login_url; ?>"><?php echo $button_login; ?></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>