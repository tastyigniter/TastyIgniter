<div class="locations-filter col-sm-3">
	<div class="panel panel-default panel-locations-filter">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('text_locations_filter_title'); ?></h3>
		</div>
		<div class="panel-body">
			<form id="filter-search-form" method="GET" class="form-search form-horizontal" action="<?php echo $search_action; ?>">
				<div class="input-group">
					<input type="text" class="form-control" name="search" value="<?php echo $search; ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form>
		</div>
		<ul class="list-group list-group-responsive wrap-bottom">
			<?php foreach ($filters as $key => $filter) { ?>
				<li class="list-group-item  <?php echo ($key === $sort_by) ? 'disabled' : '' ?>">
					<a class="btn-block" <?php echo ($key === $sort_by) ? 'disabled' : 'href="'.$filter['href'].'"'; ?>><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $filter['name']; ?></a>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>