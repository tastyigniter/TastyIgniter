<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div id="notification" class="row">
	<?php echo $this->alert->display(); ?>
	<?php if (!empty($local_alert)) { ?>
		<div class="alert alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<div class="wrap-all  bg-danger"><?php echo $local_alert; ?></div>
		</div>
	<?php } ?>
</div>
<div class="row">
	<?php echo get_partial('content_left'); ?><?php echo get_partial('content_right'); ?>

	<div class="col-xs-12">
		<div class="row wrap-all text-center" style="display:<?php echo (!$local_location) ? 'block': 'none';?>">
			<form method="POST" action="<?php echo $local_action; ?>">
				<div class="form-group">
					<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
					<div class="col-sm-4 center-block">
						<div class="input-group postcode-group">
							<input type="text" id="postcode" class="form-control text-center postcode-control" name="postcode" value="<?php echo $postcode; ?>">
							<a id="search" class="input-group-addon btn btn-success" onclick="$('form').submit();"><?php echo $text_find; ?></a>
						</div>
					</div>
				</div>
			</form>
		</div>

		<?php if ($local_location) { ?>
		<div class="search-content row" style="display: block;">
			<div id="selectedLocation" class="col-xs-5 wrap-horizontal">
				<h4><?php echo $text_local; ?></h4>
				<address>
					<strong><?php echo $location_name; ?></strong><br />
					<?php echo $location_address; ?><br />
					<?php echo $location_telephone; ?>
				</address>

				<span><?php echo $text_open_or_close; ?></span><br />
				<span><?php echo $text_reviews; ?></span>

				<?php if ($opening_hours) { ?>
				<br /><br /><strong><?php echo $text_opening_hours; ?></strong>
				<dl class="dl-horizontal opening-hour">
					<?php foreach ($opening_hours as $opening_hour) { ?>
						<dt><?php echo $opening_hour['day']; ?>:</dt>
						<?php if ($opening_hour['open'] === '00:00' OR $opening_hour['close'] === '00:00') { ?>
							<dd><?php echo $text_open; ?><dd>
						<?php } else { ?>
							<dd><?php echo $opening_hour['open']; ?> - <?php echo $opening_hour['close']; ?></dd>
						<?php } ?>
					<?php } ?>
				</dl>
				<?php } ?>
			</div>

			<div id="contactForm" class="col-xs-7 wrap-horizontal border-left">
				<form accept-charset="utf-8" method="POST" action="<?php echo $action; ?>" role="form">
					<div class="row">
						<div class="col-xs-5">
							<div class="form-group">
								<label for="subject"><b><?php echo $entry_subject; ?></b></label>
								<select name="subject" id="subject" class="form-control">
									<option value="">select a subject</option>
									<?php foreach($subjects as $subject_id => $subject) { ?>
										<option value="<?php echo $subject_id; ?>"><?php echo $subject; ?></option>
									<?php } ?>
								</select>
								<?php echo form_error('subject', '<span class="text-danger">', '</span>'); ?>
							</div>
							<div class="form-group">
								<label for="email"><b><?php echo $entry_email; ?></b></label>
								<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>" class="textfield" />
								<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="col-xs-5">
							<div class="form-group">
								<label for="full-name"><b><?php echo $entry_full_name; ?></b></label>
								<input type="text" name="full_name" id="full-name" class="form-control" value="<?php echo set_value('full_name'); ?>" class="textfield" />
								<?php echo form_error('full_name', '<span class="text-danger">', '</span>'); ?>
							</div>
							<div class="form-group">
								<label for="telephone"><b><?php echo $entry_telephone; ?></b></label>
								<input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo set_value('telephone'); ?>" class="textfield" />
								<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="comment"><b><?php echo $entry_comment; ?></b></label>
						<textarea name="comment" id="comment" class="form-control" rows="5"><?php echo set_value('comment'); ?></textarea>
						<?php echo form_error('comment', '<span class="text-danger">', '</span>'); ?>
					</div>

					<div class="buttons">
						<button type="submit" class="btn btn-success"><?php echo $button_send; ?></button>
					</div>
				</form>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php echo get_footer(); ?>