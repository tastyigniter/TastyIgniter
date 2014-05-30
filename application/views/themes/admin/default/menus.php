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
				<input type="text" name="filter_search" value="<?php echo set_value('filter_search', $filter_search); ?>" placeholder="Search name, price or stock qty." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="left">
				<select name="filter_category">
					<option value="">View all categories</option>
					<?php foreach ($categories as $category) { ?>
					<?php if ($category['category_id'] === $category_id) { ?>				
						<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('filter_category', $category['category_id'], TRUE); ?> ><?php echo $category['category_name']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('filter_category', $category['category_id']); ?> ><?php echo $category['category_name']; ?></option>
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
		
		<form id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
		<table align="center" class="list">
			<thead>
				<tr>
					<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th class="left">Photo</th>
					<th class="name sorter"><a href="<?php echo $sort_name; ?>">Name<i class="icon icon-sort-<?php echo ($sort_by == 'menu_name') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th class="left sorter"><a href="<?php echo $sort_price; ?>">Price<i class="icon icon-sort-<?php echo ($sort_by == 'menu_price') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th class="left">Category</th>
					<th class="left sorter"><a href="<?php echo $sort_stock; ?>">Stock Qty<i class="icon icon-sort-<?php echo ($sort_by == 'stock_qty') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th class="center">Status</th>
					<th class="id"><a href="<?php echo $sort_id; ?>">ID<i class="icon icon-sort-<?php echo ($sort_by == 'menu_id') ? $order_by_active : $order_by; ?>"></i></a></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($menus) {?>
				<?php foreach ($menus as $menu) { ?>
				<tr id="<?php echo $menu['menu_id']; ?>">
					<td class="action"><input type="checkbox" value="<?php echo $menu['menu_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
						<a class="edit" title="Edit" href="<?php echo $menu['edit']; ?>"></a></td>
					<td class="left"><img src="<?php echo $menu['menu_photo']; ?>"></td>
					<td class="name"><?php echo $menu['menu_name']; ?></td>
					<td class="left sorter"><?php echo $menu['menu_price']; ?></td>
					<td class="left"><?php echo $menu['category_name']; ?></td>
					<td class="left sorter"><?php echo ($menu['stock_qty'] < 1) ? '<span class="red">'.$menu['stock_qty'].'</span>' : $menu['stock_qty']; ?></td>
					<td class="center"><?php echo $menu['menu_status']; ?></td>
					<td class="id"><?php echo $menu['menu_id']; ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="8" class="center"><?php echo $text_no_menus; ?></td>
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