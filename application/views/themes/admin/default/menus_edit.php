<div class="box">
	<div id="update-box" class="content">
	<form enctype="multipart/form-data" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">Menu</a></li>
				<li><a rel="#menu-options">Menu Options</a></li>
				<li><a rel="#specials">Specials</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="menu_name" value="<?php echo set_value('menu_name', $menu_name); ?>" id="name" class="textfield" /></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Description:</b></td>
						<td><textarea name="menu_description" rows="5" cols="45"><?php echo set_value('menu_description', $menu_description); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Price:</b></td>
						<td><input type="text" name="menu_price" value="<?php echo set_value('menu_price', $menu_price); ?>" id="price" class="textfield" /></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Category:</b></td>
						<td><select name="menu_category" id="category">
							<option value="">Select category</option>
						<?php foreach ($categories as $category) { ?>
						<?php if ($menu_category === $category['category_id']) { ?>
							<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('menu_category', $category['category_id'], TRUE); ?> ><?php echo $category['category_name']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('menu_category', $category['category_id']); ?> ><?php echo $category['category_name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Photo:</b><br />
						<font size="1">Select a file to update menu photo, otherwise leave blank.</font></td>
						<td><div class="imagebox" id="selectImage">
							<div class="preview"><img src="<?php echo $menu_image_url; ?>" class="thumb" id="thumb"></div>
							<div class="select">
								<input type="hidden" name="menu_photo" value="<?php echo set_value('menu_photo', $menu_image); ?>" id="field" /><center class="name"><?php echo $image_name; ?></center><br />
								<a class="button imagebox-btn" onclick="imageUpload('field');">Select Image</a>
								<a class="button" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('center').html('no_photo.png');">Remove Image</a>
							</div>
						</div></td>
					</tr>
					<tr>
						<td><b>Stock Quantity:</b></td>
						<td><input type="text" name="stock_qty" value="<?php echo set_value('stock_qty', $stock_qty); ?>" id="stock" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Minimum Quantity:</b><br />
						<font size="1">The minimum quantity that can be ordered. Default is 1, unless set otherwise.</font></td>
						<td><input type="text" name="minimum_qty" value="<?php echo set_value('minimum_qty', $minimum_qty); ?>" id="minimum" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Subtract Stock:</b></td>
						<td><select name="subtract_stock">
							<option value="0" <?php echo set_select('subtract_stock', '0'); ?> >No</option>
						<?php if ($subtract_stock === '1') { ?>
							<option value="1" <?php echo set_select('subtract_stock', '1', TRUE); ?> >Yes</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('subtract_stock', '1'); ?> >Yes</option>
						<?php } ?>  
						</select></td>
					</tr>
					<tr>
						<td><b>Status:</b></td>
						<td><select name="menu_status">
							<option value="0" <?php echo set_select('menu_status', '0'); ?> >Disabled</option>
						<?php if ($menu_status === '1') { ?>
							<option value="1" <?php echo set_select('menu_status', '1', TRUE); ?> >Enabled</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('menu_status', '1'); ?> >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="menu-options" class="wrap_content" style="display:none;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Menu Options:</b></td>
						<td><input type="text" name="menu_option" value="" class="textfield" /></td>
					</tr>
					<tr>
						<td></td>
						<td><div id="menu-option" class="selectbox">
							<table class="list">
								<thead>
									<tr>
										<th><b>Option Name</b></th>
										<th><b>Option Price</b></th>
										<th><b>Remove</b></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($menu_options as $menu_option) { ?>
									<?php if (in_array($menu_option['option_id'], $has_options)) { ?>
									<tr id="menu-option<?php echo $menu_option['option_id']; ?>">
										<td class="name"><?php echo $menu_option['option_name']; ?></td>
										<td><?php echo $menu_option['option_price']; ?></td>
										<td class="img"><i class="icon icon-delete" onclick="$(this).parent().parent().remove();"></i><input type="hidden" name="menu_options[]" value="<?php echo $menu_option['option_id']; ?>" /></td>
									</tr>
									<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div></td>
					</tr>
				</tbody>
			</table>
		</div>
	
		<div id="specials" class="wrap_content" style="display:none;">
			<table width="400" class="form">
				<tbody>
					<tr>
						<td><b>Start Date</b></td>
						<td><input type="text" name="start_date" id="start-date" value="<?php echo set_value('start_date', $start_date); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>End Date</b></td>
						<td><input type="text" name="end_date" id="end-date" value="<?php echo set_value('end_date', $end_date); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Special Price</b></td>
						<td><input type="text" name="special_price" value="<?php echo set_value('special_price', $special_price); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Special Status</b></td>
						<td><select name="special_status">
						<?php if ($special_status) { ?>
							<option value="0" <?php echo set_select('special_status', '0'); ?> >Disabled</option>
							<option value="1" selected="selected" <?php echo set_select('special_status', '1'); ?> >Enabled</option>
						<?php } else { ?>
							<option value="0" <?php echo set_select('special_status', '0'); ?> >Disabled</option>
							<option value="1" <?php echo set_select('special_status', '1'); ?> >Enabled</option>
						<?php } ?>
						</select>
						<input type="hidden" name="special_id" value="<?php echo set_value('special_id', $special_id); ?>" /></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'dd-mm-yy',
	});
});

$('#tabs a').tabs();

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
		$('#menu-option table').append('<tr id="menu-option' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td>' + ui.item.price + '</td><td class="img">' + '<i class="icon icon-delete" onclick="$(this).parent().parent().remove();"></i>' + '<input type="hidden" name="menu_options[]" value="' + ui.item.value + '" /></td></tr>');

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<script src="<?php echo base_url("assets/js/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
function imageUpload(field) {
	$('#image-manager').remove();
		
	var iframe_url = js_site_url('admin/image_manager?popup=iframe&field_id=') + encodeURIComponent(field);

	$('#container').prepend('<div id="image-manager" style="padding: 3px 0px 0px 0px;"><iframe src="'+ iframe_url +'" width="780" height="550" frameborder="0"></iframe></div>');
	
	$('.imagebox-btn').fancybox({	
		width: 950,
		height: 600,
 		href:"#image-manager",
		autoScale: false,
		afterClose: function() {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: js_site_url('admin/image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'json',
					success: function(json) {
						var thumb = $('#' + field).parent().parent().find('.thumb');
						$(thumb).replaceWith('<img src="' + json + '" alt="" class="thumb" />');
					}
				});
			}
		}
	});
};
//--></script>