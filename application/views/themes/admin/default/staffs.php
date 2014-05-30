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
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search location, name or email." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="left">
				<select name="filter_group">
					<option value="">View all groups</option>
					<?php foreach ($staff_groups as $group) { ?>
					<?php if ($group['staff_group_id'] === $filter_group) { ?>				
						<option value="<?php echo $group['staff_group_id']; ?>" <?php echo set_select('filter_group', $group['staff_group_id'], TRUE); ?> ><?php echo $group['staff_group_name']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $group['staff_group_id']; ?>" <?php echo set_select('filter_group', $group['staff_group_id']); ?> ><?php echo $group['staff_group_name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>&nbsp;
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
				<select name="filter_date">
					<option value="">View all dates</option>
					<?php foreach ($staff_dates as $key => $value) { ?>
					<?php if ($key === $filter_date) { ?>				
						<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
				</select>&nbsp;
				<select name="filter_status">
					<option value="">View all status</option>
					<?php if ($filter_status === '1') { ?>
						<option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> >Enabled</option>
						<option value="0" <?php echo set_select('filter_status', '0'); ?> >Disabled</option>
					<?php } else if ($filter_status === '0') { ?>  
						<option value="1" <?php echo set_select('filter_status', '1'); ?> >Enabled</option>
						<option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> >Disabled</option>
					<?php } else { ?>  
						<option value="1" <?php echo set_select('filter_status', '1'); ?> >Enabled</option>
						<option value="0" <?php echo set_select('filter_status', '0'); ?> >Disabled</option>
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
					<!--<th><a href="<?php echo $sort_location; ?>">Location<i class="icon icon-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>-->
					<th><a href="<?php echo $sort_name; ?>">Name<i class="icon icon-sort-<?php echo ($sort_by == 'staff_name') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th>Email</th>
					<th><a href="<?php echo $sort_group; ?>">Staff Group<i class="icon icon-sort-<?php echo ($sort_by == 'staff_group_name') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th><a href="<?php echo $sort_location; ?>">Location<i class="icon icon-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th><a href="<?php echo $sort_date; ?>">Date Added<i class="icon icon-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th class="center">Status</th>
					<th><a href="<?php echo $sort_id; ?>">ID<i class="icon icon-sort-<?php echo ($sort_by == 'staff_id') ? $order_by_active : $order_by; ?>"></i></a></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($staffs) { ?>
				<?php foreach ($staffs as $staff) { ?>
				<tr>
					<td class="action"><input type="checkbox" value="<?php echo $staff['staff_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
						<a class="edit" title="Edit" href="<?php echo $staff['edit']; ?>"></a></td>
					<!--<td><?php echo $staff['location_name']; ?></td>-->
					<td><?php echo $staff['staff_name']; ?></td>
					<td><?php echo $staff['staff_email']; ?></td>
					<td><?php echo $staff['staff_group_name']; ?></td>
					<td><?php echo $staff['location_name']; ?></td>
					<td><?php echo $staff['date_added']; ?></td>
					<td class="center"><?php echo $staff['staff_status']; ?></td>
					<td class="id"><?php echo $staff['staff_id']; ?></td>
				</tr>
				<?php } ?>
				<?php } else {?>
				<tr>
					<td colspan="7" align="center"><?php echo $text_empty; ?></td>
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