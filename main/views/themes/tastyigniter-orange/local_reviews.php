<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h4><?php echo $text_review; ?></h4>
                    <span class="under-heading"></span>
				</div>
			</div>
		</div>

		<?php if ($local_location) { ?>
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
					<div class="row" style="display: block;">
						<div class="col-md-12 reviews-list">
							<?php if ($reviews) { ?>
								<?php $review_row = 1; ?>
								<?php foreach ($reviews as $review) { ?>
									<div class="review-item">
										<blockquote>
											<p class="review-text"><?php echo $review['text']; ?></p>
											<div class="rating-row row">
												<div class="col-sm-3">
													<b>Quality:</b><div class="rating rating-star" data-score="<?php echo $review['quality']; ?>" data-readonly="true"></div>
												</div>
												<div class="col-sm-3">
													<b>Delivery:</b><div class="rating rating-star" data-score="<?php echo $review['delivery']; ?>" data-readonly="true"></div>
												</div>
												<div class="col-sm-3">
													<b>Service:</b><div class="rating rating-star" data-score="<?php echo $review['service']; ?>" data-readonly="true"></div>
												</div>
											</div>
											<small>
												<?php echo $review['author']; ?><?php echo $text_from; ?>
												<cite title="Source Title"><?php echo $review['city']; ?></cite><?php echo $text_on; ?>
												<?php echo $review['date']; ?>
											</small>
										</blockquote>
									</div>
								<?php } ?>
							<?php } else { ?>
								<p><?php echo $text_empty; ?></p>
							<?php } ?>
						</div>

						<div class="col-md-12 wrap-horizontal">
							<div class="pagination-bar text-right clearfix">
								<div class="links"><?php echo $pagination['links']; ?></div>
								<div class="info"><?php echo $pagination['info']; ?></div>
							</div>
						</div>
					</div>
				</div>
				<?php echo get_partial('content_right'); ?>
				<?php echo get_partial('content_bottom'); ?>
			</div>
		<?php } ?>
	</div>
</div>
<?php echo get_footer(); ?>