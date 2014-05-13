<div class="box">
	<div id="list-box" class="content">
		<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<div class="filter_heading">
			<div class="left">
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search author, restaurant, order id or rating." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="right">
				<select name="filter_status">
					<option value="">View all status</option>
				<?php if ($filter_status === '1') { ?>
					<option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> >Approved</option>
					<option value="0" <?php echo set_select('filter_status', '0'); ?> >Pending Review</option>
				<?php } else if ($filter_status === '0') { ?>  
					<option value="1" <?php echo set_select('filter_status', '1'); ?> >Approved</option>
					<option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> >Pending Review</option>
				<?php } else { ?>  
					<option value="1" <?php echo set_select('filter_status', '1'); ?> >Approved</option>
					<option value="0" <?php echo set_select('filter_status', '0'); ?> >Pending Review</option>
				<?php } ?>  
				</select>&nbsp;
				<select name="filter_date">
					<option value="">View all dates</option>
					<?php foreach ($review_dates as $key => $value) { ?>
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
		
		<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table align="center" class="list list-height">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th><a href="<?php echo $sort_location; ?>">Restaurant<i class="icon icon-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_author; ?>">Author<i class="icon icon-sort-<?php echo ($sort_by == 'author') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th>Rating</th>
						<th><a href="<?php echo $sort_id; ?>">Order ID<i class="icon icon-sort-<?php echo ($sort_by == 'order_id') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_status; ?>">Status<i class="icon icon-sort-<?php echo ($sort_by == 'review_status') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th class="center"><a href="<?php echo $sort_date; ?>">Date Added<i class="icon icon-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($reviews) { ?>
					<?php foreach ($reviews as $review) { ?>
					<tr>
						<td class="action"><input type="checkbox" name="delete[]" value="<?php echo $review['review_id']; ?>" />&nbsp;&nbsp;&nbsp;
							<a class="edit" title="Edit" href="<?php echo $review['edit']; ?>"></a></td>  
						<td><?php echo $review['location_name']; ?></td>
						<td><?php echo $review['author']; ?></td>
						<td>
							<b>Quality:</b> <?php echo ($review['quality'] != '0') ? $ratings[$review['quality']] : 'None'; ?><br />
							<b>Delivery:</b> <?php echo ($review['delivery'] != '0') ? $ratings[$review['delivery']] : 'None'; ?><br />
							<b>Service:</b> <?php echo ($review['service'] != '0') ? $ratings[$review['service']] : 'None'; ?>
						</td>
						<td><?php echo $review['order_id']; ?></td>
						<td><?php echo ($review['review_status'] === '1') ? 'Approved' : 'Pending Review'; ?></td>
						<td class="center"><?php echo $review['date_added']; ?></td>
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
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}

$('input[name=\'menu\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/menus/autocomplete"); ?>?menu=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.menu_name,
						value: item.menu_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'menu\']').val(ui.item.label);
		$('input[name=\'menu_id\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'author\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/customers/autocomplete"); ?>?customer_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.customer_name,
						value: item.customer_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'author\']').val(ui.item.label);
		$('input[name=\'customer_id\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>