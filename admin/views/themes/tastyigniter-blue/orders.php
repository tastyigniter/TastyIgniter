<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
				<div class="pull-right">
					<button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
				</div>
			</div>
			<div class="panel-body panel-filter">
				<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
					<div class="filter-bar">
						<div class="form-inline">
							<div class="row">
								<div class="col-md-3 pull-right text-right">
									<div class="form-group">
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
								</div>

								<div class="col-md-9 pull-left">
									<?php if (!$user_strict_location) { ?>
										<div class="form-group">
											<select name="filter_location" class="form-control input-sm" class="form-control input-sm">
												<option value=""><?php echo lang('text_filter_location'); ?></option>
												<?php foreach ($locations as $location) { ?>
													<?php if ($location['location_id'] === $filter_location) { ?>
														<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>&nbsp;
										</div>
									<?php } ?>
									<div class="form-group">
										<select name="filter_status" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_status'); ?></option>
											<?php foreach ($statuses as $status) { ?>
											<?php if ($status['status_id'] === $filter_status) { ?>
												<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('filter_status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('filter_status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
											<?php } ?>
											<?php } ?>
											<option value="0" <?php echo ($filter_status === '0') ? 'selected' : ''; ?>><?php echo lang('text_lost_orders'); ?></option>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_type" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_order_type'); ?></option>
										<?php if ($filter_type === '1') { ?>
											<option value="1" <?php echo set_select('filter_type', '1', TRUE); ?> ><?php echo lang('text_delivery'); ?></option>
											<option value="2" <?php echo set_select('filter_type', '2'); ?> ><?php echo lang('text_collection'); ?></option>
										<?php } else if ($filter_type === '2') { ?>
											<option value="1" <?php echo set_select('filter_type', '1'); ?> ><?php echo lang('text_delivery'); ?></option>
											<option value="2" <?php echo set_select('filter_type', '2', TRUE); ?> ><?php echo lang('text_collection'); ?></option>
										<?php } else { ?>
											<option value="1" <?php echo set_select('filter_type', '1'); ?> ><?php echo lang('text_delivery'); ?></option>
											<option value="2" <?php echo set_select('filter_type', '2'); ?> ><?php echo lang('text_collection'); ?></option>
										<?php } ?>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_payment" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_payment'); ?></option>
											<?php foreach ($payments as $payment) { ?>
												<?php if ($payment['name'] === $filter_payment) { ?>
													<option value="<?php echo $payment['name']; ?>" <?php echo set_select('filter_payment', $payment['name'], TRUE); ?> ><?php echo $payment['title']; ?></option>
												<?php } else { ?>
													<option value="<?php echo $payment['name']; ?>" <?php echo set_select('filter_payment', $payment['name']); ?> ><?php echo $payment['title']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_date" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_date'); ?></option>
											<?php foreach ($order_dates as $key => $value) { ?>
											<?php if ($key === $filter_date) { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
				<table border="0" class="table table-striped table-border">
					<thead>
						<tr>
							<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
							<th><a class="sort" href="<?php echo $sort_id; ?>"><?php echo lang('column_id'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'order_id') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_location; ?>"><?php echo lang('column_location'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_customer; ?>"><?php echo lang('column_customer_name'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'first_name') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_status; ?>"><?php echo lang('column_status'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'status_name') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_type; ?>"><?php echo lang('column_type'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'order_type') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_payment; ?>"><?php echo lang('column_payment'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'payment') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_total; ?>"><?php echo lang('column_total'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'order_total') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th class="text-center"><a class="sort" href="<?php echo $sort_date; ?>"><?php echo lang('column_time_date'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($orders) { ?>
						<?php foreach ($orders as $order) { ?>
						<tr>
							<td class="action"><input type="checkbox" value="<?php echo $order['order_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
								<a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $order['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
							<td><?php echo $order['order_id']; ?></td>
							<td><?php echo $order['location_name']; ?></td>
							<td><?php echo $order['first_name'] .' '. $order['last_name']; ?></td>
                            <td><span class="label label-default" style="background-color: <?php echo $order['status_color']; ?>;"><?php echo $order['order_status']; ?></span></td>
							<td><?php echo $order['order_type']; ?></td>
							<td><?php echo $order['payment']; ?></td>
							<td><?php echo $order['order_total']; ?></td>
							<td class="text-center"><?php echo $order['order_time']; ?> - <?php echo $order['order_date']; ?></td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="10"><?php echo lang('text_empty'); ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</div>
			</form>

			<div class="pagination-bar clearfix">
				<div class="links"><?php echo $pagination['links']; ?></div>
				<div class="info"><?php echo $pagination['info']; ?></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<?php echo get_footer(); ?>