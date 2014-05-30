<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="list-box" class="content">
		<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<input type="hidden" name="show_calendar" value="<?php echo $show_calendar; ?>" />
		<div class="filter_heading">
			<div class="right">
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search id, location, customer nameor table." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="left">
				<select name="filter_location">
					<option value="">View all locations</option>
					<?php foreach ($locations as $location) { ?>
					<?php if ($location['location_id'] === $filter_location) { ?>				
						<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>&nbsp;
				<select name="filter_status">
					<option value="">View all status</option>
					<?php foreach ($statuses as $status) { ?>
					<?php if ($status['status_id'] === $filter_status) { ?>				
						<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('filter_status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('filter_status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>&nbsp;
				<?php if (!$show_calendar) { ?>
					<select name="filter_date">
						<option value="">View all dates</option>
						<?php foreach ($reserve_dates as $key => $value) { ?>
						<?php if ($key === $filter_date) { ?>				
							<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
						<?php } else { ?>
							<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
						<?php } ?>
						<?php } ?>
					</select>&nbsp;&nbsp;&nbsp;
				<?php } else { ?>
					<select name="filter_month">
						<option value="">View current month</option>
						<?php foreach ($months as $key => $value) { ?>
						<?php if ($key == $filter_month) { ?>
							<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
						<?php } else { ?>
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
						<?php } ?>
						<?php } ?>
					</select>&nbsp;
					<select name="filter_year">
						<option value="">View current year</option>
						<?php foreach ($years as $key => $value) { ?>
						<?php if ($value == $filter_year) { ?>
							<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
						<?php } else { ?>
							<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
						<?php } ?>
						<?php } ?>
					</select>&nbsp;&nbsp;&nbsp;
				<?php } ?>
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-filter"></i></a>&nbsp;
				<a class="grey_icon" href="<?php echo page_url(); ?>"><i class="icon icon-cancel"></i></a>
			</div>
		</div>
		</form>
		
		<form id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<?php if ($show_calendar) { ?>
				<?php echo $calendar; ?>
			<?php } ?>

			<table border="0" align="center" class="list list-height">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th class="id"><a href="<?php echo $sort_id; ?>">ID<i class="icon icon-sort-<?php echo ($sort_by == 'reservation_id') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_location; ?>">Location<i class="icon icon-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_customer; ?>">Customer Name<i class="icon icon-sort-<?php echo ($sort_by == 'first_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_guest; ?>">Guest(s)<i class="icon icon-sort-<?php echo ($sort_by == 'guest_num') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_table; ?>">Table<i class="icon icon-sort-<?php echo ($sort_by == 'table_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_status; ?>">Status<i class="icon icon-sort-<?php echo ($sort_by == 'status_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_staff; ?>">Assigned Staff<i class="icon icon-sort-<?php echo ($sort_by == 'staff_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th class="center"><a href="<?php echo $sort_date; ?>">Time - Date<i class="icon icon-sort-<?php echo ($sort_by == 'reserve_date') ? $order_by_active : $order_by; ?>"></i></a></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($reservations) { ?>
					<?php foreach ($reservations as $reservation) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $reservation['reservation_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="edit" title="Edit" href="<?php echo $reservation['edit']; ?>"></a></td>
						<td><?php echo $reservation['reservation_id']; ?></td>
						<td><?php echo $reservation['location_name']; ?></td>
						<td><?php echo $reservation['first_name'] .' '. $reservation['last_name']; ?></td>
						<td><?php echo $reservation['guest_num']; ?></td>
						<td><?php echo $reservation['table_name']; ?></td>
						<td><?php echo $reservation['status_name']; ?></td>
						<td><?php echo $reservation['staff_name'] ? $reservation['staff_name'] : 'NONE'; ?></td>
						<td class="center"><?php echo $reservation['reserve_time']; ?> - <?php echo $reservation['reserve_date']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="9" align="center"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>

		<div class="pagination">
			<?php echo $pagination['links']; ?><?php echo $pagination['info']; ?> 
		</div>

		<?php if ($show_calendar) { ?>
		<div class="legends">
			<h3>Legends:</h3>
			<span class="no_booking"></span> No Bookings &nbsp;&nbsp;<span class="half_booked"></span> Half Booked &nbsp;&nbsp;<span class="booked"></span> Fully Booked
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