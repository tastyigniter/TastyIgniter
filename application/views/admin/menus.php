<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD A NEW MENU</h2>
	<form enctype="multipart/form-data" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
			<td><b>Name:</b></td>
			<td><input type="text" name="menu_name" value="<?php echo set_value('menu_name'); ?>" id="name" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Description:</b></td>
			<td><textarea name="menu_description" rows="5" cols="45"><?php echo set_value('menu_description'); ?></textarea></td>
		</tr>
		<tr>
			<td><b>Price:</b></td>
			<td><input type="text" name="menu_price" value="<?php echo set_value('menu_price'); ?>" id="price" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Category:</b></td>
			<td><select name="menu_category" id="category">
				<option value=""> - please select - </option>
				<?php foreach ($categories as $category) { ?>
					<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('menu_category', $category['category_id']); ?> ><?php echo $category['category_name']; ?></option>
				<?php } ?>
			</select>
			</td>
		</tr>
		<tr>
			<td><b>Photo:</b></td>
			<td><input type="file" name="menu_photo" value="<?php echo set_value('menu_photo'); ?>" id="photo"/></td>
		</tr>
		<tr>
			<td><b>Stock Quantity:</b></td>
			<td><input type="text" name="stock_qty" value="<?php echo set_value('stock_qty'); ?>" id="stock" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Minimum Quantity:</b></td>
			<td><input type="text" name="minimum_qty" value="<?php echo set_value('minimum_qty'); ?>" id="minimum" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Subtract Stock:</b></td>
    		<td><select name="subtract_stock">
    			<option value="0" <?php echo set_select('subtract_stock', '0'); ?> >No</option>
    			<option value="1" <?php echo set_select('subtract_stock', '1'); ?> >Yes</option>
    		</select></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="menu_status">
    			<option value="0" <?php echo set_select('menu_status', '0'); ?> >Disabled</option>
    			<option value="1" <?php echo set_select('menu_status', '1'); ?> >Enabled</option>
    		</select></td>
		</tr>
	</table>

	<div class="wrap-heading">
		<h3>MENU OPTIONS</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
			<td><b>Menu Options:</b></td>
			<td><input type="text" name="menu_option" value="" class="textfield" /></td>
		</tr>
		<tr>
			<td></td>
			<td><div id="menu-option" class="selectbox"><table></table></div></td>
		</tr>
	</table>
	</div>

	<div class="wrap-heading">
		<h3>SPECIAL</h3>
	</div>

	<div class="wrap-content">
	<table width="400" class="list">
		<tr>
			<th><b></b></th>
			<th><b>Start Date</b></th>
			<th><b>End Date</b></th>
			<th><b>Special Price</b></th>
			<th><b></b></th>
		</tr>
		<tr>
			<th><b>Special:</b></th>
			<td><input type="text" name="start_date" id="start-date" value="<?php echo set_value('start_date'); ?>" class="textfield" /></td>
			<td><input type="text" name="end_date" id="end-date" value="<?php echo set_value('end_date'); ?>" class="textfield" /></td>
			<td><input type="text" name="special_price" value="<?php echo set_value('special_price'); ?>" class="textfield" /></td>
			<td><select name="menu_special">
				<option value="0" <?php echo set_select('menu_special', '0'); ?> >Disabled</option>
				<option value="1" <?php echo set_select('menu_special', '1'); ?> >Enabled</option>
			</select></td>
		</tr>
	</table>
	</div>
	</form>
	</div>
	
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th class="center">Photo</th>
			<th>Name</th>
			<th>Price</th>
			<th>Category</th>
			<th>Stock Quantity</th>
			<th class="right">Status</th>
			<th class="right">Action</th>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><select name="filter_category">
				<option value=""></option>
				<?php foreach ($categories as $category) { ?>
				<?php if ($category['category_id'] === $category_id) { ?>				
					<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('filter_category', $category['category_id'], TRUE); ?> ><?php echo $category['category_name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('filter_category', $category['category_id']); ?> ><?php echo $category['category_name']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
			</td>
			<td></td>
			<td></td>
			<td class="right"><a onclick="filter_list();">Filter</a></td>
		</tr>
		<?php if ($menus) {?>
		<?php foreach ($menus as $menu) { ?>
		<tr id="<?php echo $menu['menu_id']; ?>">
			<td><input type="checkbox" value="<?php echo $menu['menu_id']; ?>" name="delete[]" /></td>
			<td class="center"><a href="" alt="click to view full image" target="_blank"><img src="<?php echo $menu['menu_photo']; ?>" width="80" height="70"></a></td>
			<td class="menu_name"><?php echo $menu['menu_name']; ?></td>
			<td><?php echo $menu['menu_price']; ?></td>
			<td><?php echo $menu['category_name']; ?></td>
			<td><?php echo ($menu['stock_qty'] < 1) ? '<span class="red">'.$menu['stock_qty'].'</span>' : $menu['stock_qty']; ?></td>
			<td class="right"><?php echo $menu['menu_status']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $menu['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="8"><?php echo $text_no_menus; ?></td>
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
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'yy-mm-dd',
	});
  	
  	$('input[name=\'special\']').bind('change', function(){
  		if($(this).is(':checked')){
     		$('#special').fadeIn();
		} else {
   			$('#special').fadeOut();
		}
	});	
});
//--></script>
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
function filter_list() {
	url = '<?php echo current_url(); ?>';
	
	var filter_page = '<?php echo (isset($_GET["page"])) ? $_GET["page"] : FALSE; ?>';
	var filter_category = $('select[name=\'filter_category\']').val();
	
	if (filter_page != '') {
		url += '?page=' + encodeURIComponent(filter_page);
	}
	
	if (filter_category != '') {
		url += '&filter_category=' + encodeURIComponent(filter_category);
	}
	
	location = url;
}
//--></script>