<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="container">
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

			<div class="<?php echo $class; ?> top-spacing">
				<div class="row">
					<?php echo load_partial('locations_filter', $locations_filter); ?>

					<div class="location-list col-sm-9">
						<?php if ($locations) {?>
							<?php foreach ($locations as $location) { ?>
								<div class="panel panel-local">
									<div class="panel-body">
										<div class="row">
											<div class="box-one col-xs-12 col-sm-5">
												<?php if (!empty($location['location_image'])) { ?>
													<img class="img-responsive pull-left" src="<?php echo $location['location_image']; ?>">
												<?php } ?>
												<dl>
													<dd><h4><?php echo $location['location_name']; ?></h4></dd>
													<?php if (config_item('allow_reviews') !== '1') { ?>
													<dd>
														<div class="rating rating-sm text-muted">
															<span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star-half-o"></span><span class="fa fa-star-o"></span>
															<span><?php echo sprintf(lang('text_total_review'), $location['total_reviews']); ?></span>
														</div>
													</dd>
													<?php } ?>
													<dd><span class="text-muted"><?php echo $location['address']; ?></span></dd>
													<dd><span class="text-muted"><?php echo $location['distance']; ?> <?php echo $location['distance_unit']; ?></span></dd>
												</dl>
											</div>
											<div class="clearfix visible-xs wrap-bottom"></div>
											<div class="clearfix visible-xs border-top wrap-bottom"></div>
											<div class="col-xs-6 col-sm-4">
												<dl>
													<dd class="text-info">
														<?php if ($location['opening_status'] === 'open') { ?>
													<dt><?php echo lang('text_is_opened'); ?></dt>
													<?php } else if ($location['opening_status'] === 'opening') { ?>
														<dt class="text-muted"><?php echo sprintf(lang('text_opening_time'), $location['opening_time']); ?></dt>
													<?php } else { ?>
														<dt class="text-muted"><?php echo lang('text_closed'); ?></dt>
													<?php } ?>
													<dd class="text-muted">
														<?php if ($location['has_delivery']) { ?>
															<?php if ($location['delivery_status'] === 'open') { ?>
																<?php echo sprintf(lang('text_delivery_time_info'), sprintf(lang('text_in_minutes'), $location['delivery_time'])); ?>
															<?php } else if ($location['delivery_status'] === 'opening') { ?>
																<?php echo sprintf(lang('text_delivery_time_info'), sprintf(lang('text_starts'), $location['delivery_time'])); ?>
															<?php } else { ?>
																<?php echo sprintf(lang('text_delivery_time_info'), lang('text_is_closed')); ?>
															<?php } ?>
														<?php } ?>
													</dd>
													<dd class="text-muted">
														<?php if ($location['has_collection']) { ?>
															<?php if ($location['collection_status'] === 'open') { ?>
																<?php echo sprintf(lang('text_collection_time_info'), sprintf(lang('text_in_minutes'), $location['collection_time'])); ?>
															<?php } else if ($location['collection_status'] === 'opening') { ?>
																<?php echo sprintf(lang('text_collection_time_info'), sprintf(lang('text_starts'), $location['collection_time'])); ?>
															<?php } else { ?>
																<?php echo sprintf(lang('text_collection_time_info'), lang('text_is_closed')); ?>
															<?php } ?>
														<?php } ?>
													</dd>
												</dl>
											</div>
											<div class="col-xs-6 col-sm-3 text-right">
												<dl>
													<dd><a class="btn btn-primary" href="<?php echo $location['href']; ?>"><?php echo lang('button_view_menu'); ?></a></dd>
													<dd class="text-muted small">
														<?php if (!$location['has_delivery'] AND $location['has_collection']) { ?>
															<?php echo lang('text_only_collection_is_available'); ?>
														<?php } else if ($location['has_delivery'] AND !$location['has_collection']) { ?>
															<?php echo lang('text_only_delivery_is_available'); ?>
														<?php } else if ($location['has_delivery'] AND $location['has_collection']) { ?>
															<?php echo lang('text_offers_both_types'); ?>
														<?php } else { ?>
															<?php echo lang('text_offers_no_types'); ?>
														<?php } ?>
													</dd>
												</dl>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } else { ?>
							<div class="panel panel-local">
								<div class="panel-body">
									<p><?php echo lang('text_filter_no_match'); ?></p>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

				<div class="pagination-bar text-right">
					<div class="links"><?php echo $pagination['links']; ?></div>
					<div class="info"><?php echo $pagination['info']; ?></div>
				</div>
			</div>
			<?php echo get_partial('content_right', 'col-sm-3'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>