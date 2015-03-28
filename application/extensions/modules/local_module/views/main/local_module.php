<div id="local-box" class="row">
	<div id="local-info" style="display: <?php echo ($local_info ? 'block' : 'none'); ?>">
		<div class="panel panel-local display-local">
			<div class="panel-heading">
				<h4><?php echo $location_name; ?></h4>
			</div>

			<div class="panel-body">
				<div class="col-md-5">
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
				<div class="col-md-4">
					<dl>
						<dt class="text-muted"><?php echo $text_open_or_close; ?></dt>
						<dd class="text-info">
							<span class="fa fa-clock-o"></span>&nbsp;&nbsp;
							<?php if (!empty($opening_type) AND $opening_type == '24_7') { ?>
								<span><?php echo $text_open24_7; ?></span>
							<?php } else { ?>
								<span><?php echo $opening_time; ?> - <?php echo $closing_time; ?></span>
							<?php } ?>
						</dd>
					</dl>
				</div>
				<div class="col-md-3">
					<dl>
						<dd class="small"><b><?php echo $text_avail; ?>:</b> <?php echo $text_delivery; ?></dd>
					</dl>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>

		<!--<div class="panel panel-local check-local" style="display: <?php echo ($local_info ? 'none' : 'block'); ?>">
			<div class="panel-body">
				<form id="location-form" method="POST" action="<?php echo site_url('local_module/main/local_module/search'); ?>">
					<div class="col-xs-12 text-center">
						<div class="form-group">
							<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
							<div class="col-sm-4 center-block">
								<div class="input-group input-group-sm postcode-group">
									<input type="text" id="postcode" class="form-control text-center postcode-control" name="postcode" value="<?php echo $postcode; ?>">
									<a class="input-group-addon btn btn-success" onclick="searchLocal();"><?php echo $text_find; ?></a>
								</div>
							</div>
							<div id="local-alert">
								<?php if ($local_alert) { ?>
									<div class="alert">
										<?php echo $local_alert; ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>-->
	</div>
</div>