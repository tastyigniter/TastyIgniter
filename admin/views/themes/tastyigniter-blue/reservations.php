<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Reservation List</h3>
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
										<input type="hidden" name="show_calendar" value="<?php echo $show_calendar; ?>" />
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search id, location, customer nameor table." />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
								</div>

								<div class="col-md-9 pull-left">
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
									<?php if (!$show_calendar) { ?>
									<div class="form-group">
										<select name="filter_date" class="form-control input-sm">
											<option value="">View all dates</option>
											<?php foreach ($reserve_dates as $key => $value) { ?>
											<?php if ($key === $filter_date) { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
									<?php } else { ?>
									<div class="form-group">
										<select name="filter_month" class="form-control input-sm">
											<option value="">View current month</option>
											<?php foreach ($months as $key => $value) { ?>
											<?php if ($key == $filter_month) { ?>
												<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_year" class="form-control input-sm">
											<option value="">View current year</option>
											<?php foreach ($years as $key => $value) { ?>
											<?php if ($value == $filter_year) { ?>
												<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
									<?php } ?>
									<a class="btn btn-grey" onclick="filterList();" title="Filter"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="Clear"><i class="fa fa-times"></i></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
				<?php if ($show_calendar) { ?>
					<div class="table-responsive">
						<?php echo $calendar; ?>
					</div>
				<?php } ?>

				<div class="table-responsive">
					<table border="0" class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
								<th class="id"><a class="sort" href="<?php echo $sort_id; ?>">ID<i class="fa fa-sort-<?php echo ($sort_by == 'reservation_id') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_location; ?>">Location<i class="fa fa-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_customer; ?>">Customer Name<i class="fa fa-sort-<?php echo ($sort_by == 'first_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_guest; ?>">Guest(s)<i class="fa fa-sort-<?php echo ($sort_by == 'guest_num') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_table; ?>">Table<i class="fa fa-sort-<?php echo ($sort_by == 'table_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_status; ?>">Status<i class="fa fa-sort-<?php echo ($sort_by == 'status_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_staff; ?>">Assigned Staff<i class="fa fa-sort-<?php echo ($sort_by == 'staff_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th class="text-center"><a class="sort" href="<?php echo $sort_date; ?>">Time - Date<i class="fa fa-sort-<?php echo ($sort_by == 'reserve_date') ? $order_by_active : $order_by; ?>"></i></a></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($reservations) { ?>
							<?php foreach ($reservations as $reservation) { ?>
							<tr>
								<td class="action"><input type="checkbox" value="<?php echo $reservation['reservation_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
									<a class="btn btn-edit" title="Edit" href="<?php echo $reservation['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
								<td><?php echo $reservation['reservation_id']; ?></td>
								<td><?php echo $reservation['location_name']; ?></td>
								<td><?php echo $reservation['first_name'] .' '. $reservation['last_name']; ?></td>
								<td><?php echo $reservation['guest_num']; ?></td>
								<td><?php echo $reservation['table_name']; ?></td>
                                <td><span class="label label-default" style="background-color: <?php echo $reservation['status_color']; ?>;"><?php echo $reservation['status_name']; ?></span></td>
                                <td><?php echo $reservation['staff_name'] ? $reservation['staff_name'] : 'NONE'; ?></td>
								<td class="text-center"><?php echo $reservation['reserve_time']; ?> - <?php echo $reservation['reserve_date']; ?></td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td colspan="9"><?php echo $text_empty; ?></td>
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

			<?php if ($show_calendar) { ?>
				<div class="panel-footer">
					<div class="legends">
						<span class="no_booking"></span>&nbsp; No Bookings &nbsp;&nbsp;
						<span class="half_booked"></span>&nbsp; Half Booked &nbsp;&nbsp;
						<span class="booked"></span>&nbsp; Fully Booked
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<?php echo get_footer(); ?>