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
		<div class="filter_heading">
			<div class="right">
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search order id, location or customer name." class="textfield" />&nbsp;&nbsp;&nbsp;
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
				<select name="filter_type">
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
				<select name="filter_date">
					<option value="">View all dates</option>
					<?php foreach ($order_dates as $key => $value) { ?>
					<?php if ($key === $filter_date) { ?>				
						<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
				</select>&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-filter"></i></a>&nbsp;
				<a class="grey_icon" href="<?php echo page_url(); ?>"><i class="icon icon-cancel"></i></a>
			</div>
		</div>
		</form>
		
		<form id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table border="0" class="list list-height">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th><a href="<?php echo $sort_id; ?>">ID<i class="icon icon-sort-<?php echo ($sort_by == 'order_id') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_location; ?>">Location<i class="icon icon-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_customer; ?>">Customer Name<i class="icon icon-sort-<?php echo ($sort_by == 'first_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_status; ?>">Status<i class="icon icon-sort-<?php echo ($sort_by == 'status_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_type; ?>">Type<i class="icon icon-sort-<?php echo ($sort_by == 'order_type') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_total; ?>">Total<i class="icon icon-sort-<?php echo ($sort_by == 'order_total') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th class="center"><a href="<?php echo $sort_date; ?>">Time - Date<i class="icon icon-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($orders) { ?>
					<?php foreach ($orders as $order) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $order['order_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="edit" title="Edit" href="<?php echo $order['edit']; ?>"></a></td>
						<td><?php echo $order['order_id']; ?></td>
						<td><?php echo $order['location_name']; ?></td>
						<td><?php echo $order['first_name'] .' '. $order['last_name']; ?></td>
						<td><?php echo $order['order_status']; ?></td>
						<td><?php echo $order['order_type']; ?></td>
						<td><?php echo $order['order_total']; ?></td>
						<td class="center"><?php echo $order['order_time']; ?> - <?php echo $order['date_added']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="10" align="center"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	
		<div class="pagination">
			<?php echo $pagination['links']; ?><?php echo $pagination['info']; ?>
		</div>
	</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>