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
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search name, city or postcode." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="left">
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
		<table border="0" align="center" class="list list-height">
			<thead>
				<tr>
					<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th><a href="<?php echo $sort_name; ?>">Name<i class="icon icon-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th><a href="<?php echo $sort_city; ?>">City<i class="icon icon-sort-<?php echo ($sort_by == 'location_city') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th><a href="<?php echo $sort_postcode; ?>">Postcode<i class="icon icon-sort-<?php echo ($sort_by == 'location_postcode') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th>Telephone</th>
					<th class="center">Status</th>
					<th class="id"><a href="<?php echo $sort_id; ?>">ID<i class="icon icon-sort-<?php echo ($sort_by == 'location_id') ? $order_by_active : $order_by; ?>"></i></a></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($locations) { ?>
				<?php foreach ($locations as $location) { ?>
				<tr>
					<td class="action"><input type="checkbox" value="<?php echo $location['location_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
						<a class="edit" title="Edit" href="<?php echo $location['edit']; ?>"></a></td>
					<td><?php echo $location['location_name']; ?>
						<?php if ($default_location_id === $location['location_id']) { ?>
						<b>(Default)</b>
						<?php } ?>
					</td>
					<td><?php echo $location['location_city']; ?></td>
					<td><?php echo $location['location_postcode']; ?></td>
					<td><?php echo $location['location_telephone']; ?></td>
					<td class="center"><?php echo $location['location_status']; ?></td>
					<td class="id"><?php echo $location['location_id']; ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
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