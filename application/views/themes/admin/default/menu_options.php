<div class="box">
	<div id="list-box" class="content">
		<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<div class="filter_heading">
			<div class="left">
				<input type="text" name="filter_search" value="<?php echo set_value('filter_search', $filter_search); ?>" placeholder="Search name or price." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
		</div>
		</form>
		
		<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table align="center" class="list list-height">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th class="sorter"><a href="<?php echo $sort_name; ?>">Name<i class="icon icon-sort-<?php echo ($sort_by == 'option_name') ? $order_by.' active' : $order_by; ?>"></i></a></th>
						<th class="sorter"><a href="<?php echo $sort_price; ?>">Price<i class="icon icon-sort-<?php echo ($sort_by == 'option_price') ? $order_by.' active' : $order_by; ?>"></i></a></th>
						<th class="id"><a href="<?php echo $sort_id; ?>">ID<i class="icon icon-sort-<?php echo ($sort_by == 'option_id') ? $order_by.' active' : $order_by; ?>"></i></a></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($menu_options) {?>
					<?php foreach ($menu_options as $menu_option) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $menu_option['option_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="edit" title="Edit" href="<?php echo $menu_option['edit']; ?>"></a></td>
						<td><?php echo $menu_option['option_name']; ?></td>
						<td><?php echo $menu_option['option_price']; ?></td>
						<td class="id"><?php echo $menu_option['option_id']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="4" align="center"><?php echo $text_empty; ?></td>
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