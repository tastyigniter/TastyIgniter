<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
			<div class="filter-bar">
				<div class="form-inline">
					<div class="row">
						<div class="col-md-3 pull-right text-right">
							<div class="form-group">
								<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search order id, location or customer name." />&nbsp;&nbsp;&nbsp;
							</div>
							<a class="btn btn-grey input-sm" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
						</div>

						<div class="col-md-8 pull-left">
							<div class="form-group">
								<select name="filter_location" class="form-control input-sm" class="form-control input-sm">
									<option value="">View all locations</option>
									<?php foreach ($locations as $location) { ?>
									<?php if ($location['location_id'] === $filter_location) { ?>				
										<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>&nbsp;
							</div>
							<div class="form-group">
								<select name="filter_status" class="form-control input-sm">
									<option value="">View all status</option>
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_id'] === $filter_status) { ?>				
										<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('filter_status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('filter_status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>&nbsp;
							</div>
							<div class="form-group">
								<select name="filter_type" class="form-control input-sm">
									<option value="">View all order types</option>
								<?php if ($filter_type === '1') { ?>
									<option value="1" <?php echo set_select('filter_type', '1', TRUE); ?> >Delivery</option>
									<option value="2" <?php echo set_select('filter_type', '2'); ?> >Collection</option>
								<?php } else if ($filter_type === '2') { ?>  
									<option value="1" <?php echo set_select('filter_type', '1'); ?> >Delivery</option>
									<option value="2" <?php echo set_select('filter_type', '2', TRUE); ?> >Collection</option>
								<?php } else { ?>  
									<option value="1" <?php echo set_select('filter_type', '1'); ?> >Delivery</option>
									<option value="2" <?php echo set_select('filter_type', '2'); ?> >Collection</option>
								<?php } ?>  
								</select>&nbsp;
							</div>
							<div class="form-group">
								<select name="filter_date" class="form-control input-sm">
									<option value="">View all dates</option>
									<?php foreach ($order_dates as $key => $value) { ?>
									<?php if ($key === $filter_date) { ?>				
										<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
									<?php } else { ?>
										<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
							<a class="btn btn-grey input-sm" onclick="filterList();" title="Filter"><i class="fa fa-filter"></i></a>&nbsp;
							<a class="btn btn-grey input-sm" href="<?php echo page_url(); ?>" title="Clear"><i class="fa fa-times"></i></a>
						</div>
					</div>
				</div>
			</div>
		</form>
		
		<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table border="0" class="table table-striped table-border">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th><a class="sort" href="<?php echo $sort_id; ?>">ID<i class="fa fa-sort-<?php echo ($sort_by == 'order_id') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a class="sort" href="<?php echo $sort_location; ?>">Location<i class="fa fa-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a class="sort" href="<?php echo $sort_customer; ?>">Customer Name<i class="fa fa-sort-<?php echo ($sort_by == 'first_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a class="sort" href="<?php echo $sort_status; ?>">Status<i class="fa fa-sort-<?php echo ($sort_by == 'status_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a class="sort" href="<?php echo $sort_type; ?>">Type<i class="fa fa-sort-<?php echo ($sort_by == 'order_type') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a class="sort" href="<?php echo $sort_total; ?>">Total<i class="fa fa-sort-<?php echo ($sort_by == 'order_total') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th class="text-center"><a class="sort" href="<?php echo $sort_date; ?>">Time - Date<i class="fa fa-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($orders) { ?>
					<?php foreach ($orders as $order) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $order['order_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="btn btn-edit" title="Edit" href="<?php echo $order['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
						<td><?php echo $order['order_id']; ?></td>
						<td><?php echo $order['location_name']; ?></td>
						<td><?php echo $order['first_name'] .' '. $order['last_name']; ?></td>
						<td><?php echo $order['order_status']; ?></td>
						<td><?php echo $order['order_type']; ?></td>
						<td><?php echo $order['order_total']; ?></td>
						<td class="text-center"><?php echo $order['date_added']; ?> - <?php echo $order['order_time']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="10"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	
		<div class="pagination-bar clearfix">
			<div class="links"><?php echo $pagination['links']; ?></div>
			<div class="info"><?php echo $pagination['info']; ?></div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<?php echo $footer; ?>