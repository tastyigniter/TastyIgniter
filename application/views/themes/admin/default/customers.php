<div class="box">
	<div id="list-box" class="content">
		<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<div class="filter_heading">
			<div class="left">
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search customer name or email." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="right">
				<select name="filter_date">
					<option value="">View all dates</option>
					<?php foreach ($customer_dates as $key => $value) { ?>
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
		
		<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table border="0" class="list list-height">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th><a href="<?php echo $sort_first; ?>">First Name<i class="icon icon-sort-<?php echo ($sort_by == 'first_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_last; ?>">Last Name<i class="icon icon-sort-<?php echo ($sort_by == 'last_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_email; ?>">Email<i class="icon icon-sort-<?php echo ($sort_by == 'email') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th>Telephone</th>
						<th><a href="<?php echo $sort_date; ?>">Date Added<i class="icon icon-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th class="center">Status</th>
						<th class="id"><a href="<?php echo $sort_id; ?>">ID<i class="icon icon-sort-<?php echo ($sort_by == 'customer_id') ? $order_by_active : $order_by; ?>"></i></a></th>
					</tr>
				</thead>
				<tbody>
				<?php if ($customers) { ?>
				<?php foreach ($customers as $customer) { ?>
				<tr>
					<td class="action"><input type="checkbox" value="<?php echo $customer['customer_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
						<a class="edit" title="Edit" href="<?php echo $customer['edit']; ?>"></a></td>
					<td><?php echo $customer['first_name']; ?></td>
					<td><?php echo $customer['last_name']; ?></td>
					<td><?php echo $customer['email']; ?></td>
					<td><?php echo $customer['telephone']; ?></td>
					<td><?php echo $customer['date_added']; ?></td>
					<td class="center"><?php echo $customer['status']; ?></td>
					<td class="id"><?php echo $customer['customer_id']; ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="8" align="center"><?php echo $text_empty; ?></td>
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
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>