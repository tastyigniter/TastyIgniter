<div id="local-box">
	<?php if ($module_position === 'top') { ?>
	<div class="container">
		<div class="row">
			<div id="local-info" class="col-md-12" style="display: <?php echo ($local_info ? 'block' : 'none'); ?>">
	<?php } else { ?>
			<div id="local-info" style="display: <?php echo ($local_info ? 'block' : 'none'); ?>">
	<?php } ?>
				<div class="panel panel-local display-local">
					<div class="panel-heading">
						<div class="col-xs-12 col-sm-6 col-md-7">
							<h4><?php echo $location_name; ?></h4>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-5 text-right">
							<a class="btn btn-primary btn-menus" href="<?php echo site_url('menus'); ?>"><i class="fa fa-cutlery"></i><span>&nbsp;&nbsp;<?php echo $text_goto_menus; ?></span></a>
							<a class="btn btn-warning" href="<?php echo site_url('local/reviews'); ?>"><i class="fa fa-heart"></i><span>&nbsp;&nbsp;<?php echo $text_reviews; ?></span></a>
							<a class="btn btn-info" href="<?php echo site_url('local'); ?>"><i class="fa fa-ellipsis-h"></i><span>&nbsp;&nbsp;<?php echo $text_more_info; ?></span></a>
						</div>
					</div>

					<div class="panel-body">
						<div class="col-sm-5 col-md-5">
							<dl>
								<dd><span class="text-muted"><?php echo $location_address; ?></span></dd>
								<dd>
									<div class="rating rating-sm">
										<span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star-half-o"></span><span class="fa fa-star-o"></span>
									</div>
									<span class="small"><?php echo $text_total_review; ?></span>
								</dd>
							</dl>
						</div>
						<div class="col-sm-4 col-md-4">
							<dl>
								<dt class="text-muted"><?php echo $text_open_or_close; ?></dt>
								<dd class="text-info">
									<?php if (!empty($opening_type) AND $opening_type == '24_7') { ?>
										<span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo $text_open24_7; ?></span>
									<?php } else if (empty($opening_status)) { ?>
										<span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo $opening_time; ?> - <?php echo $closing_time; ?></span>
									<?php } ?>
								</dd>
							</dl>
						</div>
						<div class="col-sm-3 col-md-3">
							<dl>
								<dd><b><?php echo $text_avail; ?>:</b> <?php echo $text_delivery; ?></dd>
							</dl>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
<?php if ($module_position === 'top') { ?>
		</div>
	</div>
<?php } ?>
</div>
