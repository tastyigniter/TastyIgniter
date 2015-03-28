<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<?php foreach ($types as $key => $value) { ?>
					<?php if ($key === $filter_type) { ?>
						<li class="active"><a href="<?php echo $value['url']; ?>"><?php echo ucwords($key); ?> &nbsp;<span class="badge"><?php echo $value['badge']; ?></span></a></li>
					<?php } else { ?>
						<li><a href="<?php echo $value['url']; ?>"><?php echo ucwords($key); ?> &nbsp;<span class="badge"><?php echo $value['badge']; ?></span></a></li>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>

		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Customer Activity List</h3>
				<div class="pull-right">
					<button class="btn btn-default btn-xs btn-filter"><i class="fa fa-filter"></i></button>
				</div>
			</div>
			<div class="panel-body panel-filter">
				<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
					<div class="filter-bar">
						<div class="form-inline">
							<div class="row">
								<div class="col-md-3 pull-right text-right">
									<div class="form-group">
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search ip, customer or browser." />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
								</div>

								<div class="col-md-8 pull-left">
									<input type="hidden" name="filter_type" value="<?php echo $filter_type; ?>" />
									<div class="form-group">
										<select name="filter_access" class="form-control input-sm">
											<option value="">View all access</option>
										<?php if ($filter_access === 'browser') { ?>
											<option value="browser" <?php echo set_select('filter_access', 'browser', TRUE); ?> >Browser</option>
											<option value="mobile" <?php echo set_select('filter_access', 'mobile'); ?> >Mobile</option>
											<option value="robot" <?php echo set_select('filter_access', 'robot'); ?> >Robot</option>
										<?php } else if ($filter_access === 'mobile') { ?>
											<option value="browser" <?php echo set_select('filter_access', 'browser'); ?> >Browser</option>
											<option value="mobile" <?php echo set_select('filter_access', 'mobile', TRUE); ?> >Mobile</option>
											<option value="robot" <?php echo set_select('filter_access', 'robot'); ?> >Robot</option>
										<?php } else if ($filter_access === 'robot') { ?>
											<option value="browser" <?php echo set_select('filter_access', 'browser'); ?> >Browser</option>
											<option value="mobile" <?php echo set_select('filter_access', 'mobile'); ?> >Mobile</option>
											<option value="robot" <?php echo set_select('filter_access', 'robot', TRUE); ?> >Robot</option>
										<?php } else { ?>
											<option value="browser" <?php echo set_select('filter_access', 'browser'); ?> >Browser</option>
											<option value="mobile" <?php echo set_select('filter_access', 'mobile'); ?> >Mobile</option>
											<option value="robot" <?php echo set_select('filter_access', 'robot'); ?> >Robot</option>
										<?php } ?>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_date" class="form-control input-sm">
											<option value="">View all activities</option>
											<?php foreach ($activity_dates as $key => $value) { ?>
											<?php if ($key === $filter_date) { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="Filter"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="Clear"><i class="fa fa-times"></i></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<form role="form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
				<table border="0" class="table table-striped table-border">
					<thead>
						<tr>
							<th class="action action-one"></th>
							<th>IP</th>
							<th>Customer</th>
							<th>Access</th>
							<th>Browser</th>
							<th style="width:22%;">Request URL</th>
							<th style="width:22%;">Referrer URL</th>
							<th><a class="sort" href="<?php echo $sort_date; ?>">Last Activity<i class="fa fa-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($activities) { ?>
						<?php foreach ($activities as $activity) { ?>
						<tr>
							<td class="action action-one"><a class="btn btn-blacklist" title="Blacklist" href="<?php echo $activity['blacklist']; ?>"><i class="fa fa-ban"></i></a></td>
							<td><?php echo $activity['ip_address']; ?>&nbsp;&nbsp;<img class="flag" title="<?php echo $activity['country_name']; ?>" width="16" src="<?php echo $activity['country_code']; ?>" /></td>
							<td><?php echo $activity['customer_name']; ?></td>
							<td><?php echo $activity['access_type']; ?></td>
							<td><?php echo $activity['browser']; ?></td>
							<td><?php echo $activity['request_uri']; ?></td>
							<td><?php echo $activity['referrer_uri']; ?></td>
							<td><?php echo $activity['date_added']; ?></td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="8"><?php echo $text_empty; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>

				<div class="pagination-bar clearfix">
					<div class="links"><?php echo $pagination['links']; ?></div>
					<div class="info"><?php echo $pagination['info']; ?></div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<?php echo $footer; ?>