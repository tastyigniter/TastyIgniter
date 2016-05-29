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
					<form method="POST" accept-charset="utf-8" action="<?php echo $_action; ?>" role="form">
						<div class="col-md-12">
							<div class="form-group">
								<label for="location"><?php echo lang('label_restaurant'); ?></label>
								<input type="text" id="location" class="form-control" value="<?php echo $restaurant_name; ?>" disabled />
								<input type="hidden" name="location_id" value="<?php echo $location_id; ?>" <?php echo set_value('location_id', $location_id); ?> />
							</div>
							<div class="form-group">
								<label for="customer"><?php echo lang('label_customer_name'); ?></label>
								<input type="text" id="customer" class="form-control" value="<?php echo $customer_name; ?>" disabled />
								<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
							</div>
							<div class="form-inline">
								<div class="form-group wrap-horizontal wrap-right">
									<label for="quality"><?php echo lang('label_quality'); ?></label>
									<div class="rating rating-star" data-score="<?php echo $rating['quality']; ?>" data-score-name="rating[quality]"></div>
									<?php echo form_error('rating[quality]', '<span class="text-danger">', '</span>'); ?>
								</div>
								<div class="form-group wrap-horizontal wrap-right">
									<label for="delivery"><?php echo lang('label_delivery'); ?></label>
									<div class="rating rating-star" data-score="<?php echo $rating['delivery']; ?>" data-score-name="rating[delivery]"></div>
									<?php echo form_error('rating[delivery]', '<span class="text-danger">', '</span>'); ?>
								</div>
								<div class="form-group wrap-horizontal">
									<label for="service"><?php echo lang('label_service'); ?></label>
									<div class="rating rating-star" data-score="<?php echo $rating['service']; ?>" data-score-name="rating[service]"></div>
									<?php echo form_error('rating[service]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="review-text"><?php echo lang('label_review'); ?></label>
								<textarea name="review_text" id="review-text" rows="5" class="form-control"><?php echo set_value('review_text'); ?></textarea>
								<?php echo form_error('review_text', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>

						<div class="col-md-12">
							<div class="buttons">
								<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
								<button type="submit" class="btn btn-success"><?php echo lang('button_review'); ?></button>
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
<script type="text/javascript"><!--
$(document).ready(function() {
	var ratings = <?php echo json_encode(array_values($ratings)); ?>;
	displayRatings(ratings);
});
//--></script>
<?php echo get_footer(); ?>