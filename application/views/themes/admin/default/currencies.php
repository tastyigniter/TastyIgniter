<div class="box">
	<div id="list-box" class="content">
		<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<div class="filter_heading">
			<div class="left">
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search name or code." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="right">
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
			<table align="center" class="list list-height">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th><a href="<?php echo $sort_name; ?>">Title<i class="icon icon-sort-<?php echo ($sort_by == 'currency_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_code; ?>">Code<i class="icon icon-sort-<?php echo ($sort_by == 'currency_code') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a href="<?php echo $sort_country; ?>">Country<i class="icon icon-sort-<?php echo ($sort_by == 'country_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th class="center">Symbol</th>
						<th class="center">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($currencies) {?>
					<?php foreach ($currencies as $currency) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $currency['currency_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="edit" title="Edit" href="<?php echo $currency['edit']; ?>"></a></td>
						<td><?php echo $currency['currency_name']; ?>
							<?php if ($currency_id === $currency['currency_id']) { ?>
							<b>(Default)</b>
							<?php } ?>
						</td>
						<td><?php echo $currency['currency_code']; ?></td>
						<td><?php echo $currency['country_name']; ?></td>
						<td class="center"><?php echo $currency['currency_symbol']; ?></td>
						<td class="center"><?php echo ($currency['currency_status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="6" align="center"><?php echo $text_empty; ?></td>
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