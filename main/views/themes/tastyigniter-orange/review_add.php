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
					<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>" role="form">
						<div class="col-md-12">
							<div class="form-group">
								<label for="location"><?php echo $entry_restaurant; ?></label>
								<input type="text" id="location" class="form-control" value="<?php echo $restaurant_name; ?>" disabled />
								<input type="hidden" name="location_id" value="<?php echo $location_id; ?>" <?php echo set_value('location_id', $location_id); ?> />
							</div>
							<div class="form-group">
								<label for="customer"><?php echo $entry_customer_name; ?></label>
								<input type="text" id="customer" class="form-control" value="<?php echo $customer_name; ?>" disabled />
								<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
							</div>
							<div class="form-inline">
								<div class="form-group wrap-horizontal wrap-right">
									<label for="quality"><?php echo $entry_quality; ?></label>
									<div class="rating rating-star" data-score="<?php echo $rating['quality']; ?>" data-score-name="rating[quality]"></div>
									<?php echo form_error('rating[quality]', '<span class="text-danger">', '</span>'); ?>
								</div>
								<div class="form-group wrap-horizontal wrap-right">
									<label for="delivery"><?php echo $entry_delivery; ?></label>
									<div class="rating rating-star" data-score="<?php echo $rating['delivery']; ?>" data-score-name="rating[delivery]"></div>
									<?php echo form_error('rating[delivery]', '<span class="text-danger">', '</span>'); ?>
								</div>
								<div class="form-group wrap-horizontal">
									<label for="service"><?php echo $entry_service; ?></label>
									<div class="rating rating-star" data-score="<?php echo $rating['service']; ?>" data-score-name="rating[service]"></div>
									<?php echo form_error('rating[service]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="review-text"><?php echo $entry_review; ?></label>
								<textarea name="review_text" id="review-text" rows="5" class="form-control"><?php echo set_value('review_text'); ?></textarea>
								<?php echo form_error('review_text', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>

						<div class="col-md-12">
							<div class="buttons">
								<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
								<button type="submit" class="btn btn-success"><?php echo $button_review; ?></button>
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