<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div id="marketplace-search" class="form-group">
			<div>
				<i class="fa fa-search fa-icon"></i>
				<i class="fa fa-spinner fa-icon loading" style="display: none"></i>
				<input class="form-control search input-lg"
					   placeholder="<?php echo sprintf(lang('text_search'), $item_type); ?>" type="text"
					   data-search-type="<?php echo $item_type; ?>" data-search-ready="false">
			</div>
		</div>

		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h4 class="panel-title"><?php echo sprintf(lang('text_popular_title'), ucwords(plural($item_type))) ?></h4>
			</div>
			<div class="panel-body">
				<div id="marketplace-items" class="items-list">
					<?php if (is_array($items)) { ?>
						<ul class="select-box">
							<?php foreach ($items['data'] as $item) { ?>
								<li class="col-xs-12 col-sm-4">
									<div class="panel panel-default">
										<div class="panel-heading">
											<div class="pull-right">
												<?php if (!empty($item['installed'])) { ?>
													<button class="btn btn-default disabled" title="Added">
														<i class="fa fa-cloud-download"></i>
													</button>
												<?php } else { ?>
													<button class="btn btn-default btn-install" data-title="Add <?php echo $item['name'] ?>" data-install-code="<?php echo $item['code'] ?>"
															data-install-type="<?php echo $item['type'] ?>" data-install-version="<?php echo $item['version'] ?>">
														<i class="fa fa-cloud-download text-success"></i>
													</button>
												<?php } ?>
											</div>
											<h4 class="panel-title"><?php echo character_limiter($item['name'], 22) ?></h4>
										</div>
										<div class="panel-body">
											<div class="media">
												<a class="media-left media-middle">
													<?php if (!empty($item['thumb'])) { ?>
														<img src="<?php echo $item['thumb'] ?>" class="img-rounded" alt="No Image" style="width: 64px; height: 64px;">
													<?php } else { ?>
														<i class="fa <?php echo $item['icon'] ?> fa-3x text-muted"></i>
													<?php } ?>
												</a>
												<div class="media-body small">
													<?php echo character_limiter($item['description'], 72); ?>
												</div>
											</div>
										</div>
									</div>
								</li>
							<?php } ?>
						</ul>
					<?php } else { ?>
						<p><?php echo $items; ?></p>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var updatesItems = JSON.parse('<?php echo json_encode(!empty($items['data']) ? $items['data'] : []); ?>');
	var installedItems = JSON.parse('<?php echo json_encode($installed_items); ?>');
</script>
<?php echo get_footer(); ?>