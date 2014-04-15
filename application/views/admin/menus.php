<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th class="center">Photo</th>
			<th>Name</th>
			<th class="right">Price</th>
			<th class="center">Category</th>
			<th class="center">Stock Quantity</th>
			<th class="center">Status</th>
			<th class="right">Action</th>
		</tr>
		<tr class="filter">
			<th></th>
			<th></th>
			<th><input type="text" name="filter_name" value="<?php echo set_value('filter_name', $filter_name); ?>" class="textfield" size="30"/></th>
			<th class="right"><input type="text" name="filter_price" value="<?php echo set_value('filter_price', $filter_price); ?>" class="textfield" size="5" style="text-align:right" /></th>
			<th class="center"><select name="filter_category">
				<option value=""></option>
				<?php foreach ($categories as $category) { ?>
				<?php if ($category['category_id'] === $category_id) { ?>				
					<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('filter_category', $category['category_id'], TRUE); ?> ><?php echo $category['category_name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('filter_category', $category['category_id']); ?> ><?php echo $category['category_name']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
			</th>
			<th class="center"><input type="text" name="filter_stock" value="<?php echo set_value('filter_stock', $filter_stock); ?>" class="textfield" size="5" /></th>
			<th class="center"><select name="filter_status">
				<option value=""></option>
			<?php if ($filter_status === '1') { ?>
				<option value="0" <?php echo set_select('filter_status', '0'); ?> >Disabled</option>
				<option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> >Enabled</option>
			<?php } else if ($filter_status === '0') { ?>  
				<option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> >Disabled</option>
				<option value="1" <?php echo set_select('filter_status', '1'); ?> >Enabled</option>
			<?php } else { ?>  
				<option value="0" <?php echo set_select('filter_status', '0'); ?> >Disabled</option>
				<option value="1" <?php echo set_select('filter_status', '1'); ?> >Enabled</option>
			<?php } ?>  
			</select></th>
			<th class="right"><a class="button add_button" onclick="filterList();">Filter</a>  <img onclick="filterClear();" title="Clear Filter" src="<?php echo base_url('assets/img/delete.png'); ?>" /></th>
		</tr>
		<?php if ($menus) {?>
		<?php foreach ($menus as $menu) { ?>
		<tr id="<?php echo $menu['menu_id']; ?>">
			<td><input type="checkbox" value="<?php echo $menu['menu_id']; ?>" name="delete[]" /></td>
			<td class="center"><img src="<?php echo $menu['menu_photo']; ?>"></td>
			<td class="menu_name"><?php echo $menu['menu_name']; ?></td>
			<td class="right"><?php echo $menu['menu_price']; ?></td>
			<td class="center"><?php echo $menu['category_name']; ?></td>
			<td class="center"><?php echo ($menu['stock_qty'] < 1) ? '<span class="red">'.$menu['stock_qty'].'</span>' : $menu['stock_qty']; ?></td>
			<td class="center"><?php echo $menu['menu_status']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $menu['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="8" class="center"><?php echo $text_no_menus; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>

	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
	</div>	
</div>
<script type="text/javascript"><!--
$('input[name=\'menu_option\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/menu_options/autocomplete"); ?>?option_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.option_name,
						value: item.option_id,
						price: item.option_price
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#menu-option' + ui.item.value).remove();
		$('#menu-option table').append('<tr id="#menu-option' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td>' + ui.item.price + '</td><td class="img">' + '<img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$(this).parent().parent().remove();" />' + '<input type="hidden" name="menu_options[]" value="' + ui.item.value + '" /></td></tr>');

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#menu-option tr img').click(function() {
	$(this).parent().parent().remove();
}); 
//--></script>

<script type="text/javascript"><!--
function filterList() {
	url = '<?php echo current_url(); ?>';
	
	var filter_page = '<?php echo (isset($_GET["page"])) ? $_GET["page"] : FALSE; ?>';
	var filter_name = $('input[name=\'filter_name\']').val();
	var filter_price = $('input[name=\'filter_price\']').val();
	var filter_category = $('select[name=\'filter_category\']').val();
	var filter_stock = $('input[name=\'filter_stock\']').val();
	var filter_status = $('select[name=\'filter_status\']').val();
	
	if (filter_page != '') {
		url += '?page=' + encodeURIComponent(filter_page);
	} else {
		url += '?page=';
	}
	
	if (filter_name != '') {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	if (filter_price != '') {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}
	
	if (filter_category != '') {
		url += '&filter_category=' + encodeURIComponent(filter_category);
	}
	
	if (filter_stock != '') {
		url += '&filter_stock=' + encodeURIComponent(filter_stock);
	}
	
	if (filter_status != '') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}
	
	location = url;
}

function filterClear() {
	url = '<?php echo current_url(); ?>';
	
	location = url;
}
//--></script>