<div class="box">
	<div id ="update-box" class="border_all">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" enctype="multipart/form-data" />
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">General</a></li>
				<li><a rel="#menu-list">Menu List</a></li>
				<li><a rel="#location">Location</a></li>
				<li><a rel="#registration">Registration</a></li>
				<li><a rel="#order">Order</a></li>
				<li><a rel="#reservation">Reservation</a></li>
				<li><a rel="#mail">Mail</a></li>
				<li><a rel="#log">Log</a></li>
				<li><a rel="#security">Security</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span> <b>Restaurant Name:</b></td>
					<td><input type="text" name="site_name" value="<?php echo $site_name; ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Restaurant Logo:</b></td>
					<td><div class="imagebox" id="selectImage">
						<div class="preview"><img src="<?php echo $site_logo; ?>" class="thumb" id="thumb"></div>
						<div class="select">
							<input type="hidden" name="site_logo" value="<?php echo set_value('site_logo', $logo_val); ?>" id="field" /><center class="name"><?php echo $logo_name; ?></center><br />
							<a class="button imagebox-btn" onclick="imageUpload('field');">Select Image</a>
							<a class="button" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('center').html('no_photo.png');">Remove Image</a>
						</div>
					</div></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Restaurant Email:</b></td>
					<td><input type="text" name="site_email" value="<?php echo $site_email; ?>" class="textfield" autocomplete="off" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Restaurant Country:</b></td>
					<td><select name="country_id">
					<?php foreach ($countries as $country) { ?>
					<?php if ($country['country_id'] === $country_id) { ?>
						<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Restaurant Timezone:</b></td>
					<td><select name="timezone">
					<?php foreach ($timezones as $key => $value) { ?>
					<?php if ($key === $timezone) { ?>
						<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Restaurant Currency:</b></td>
					<td><select name="currency_id">
					<?php foreach ($currencies as $currency) { ?>
					<?php if ($currency['currency_id'] === $currency_id) { ?>
						<option value="<?php echo $currency['currency_id']; ?>" selected="selected"><?php echo $currency['currency_title']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['currency_title']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Default Location:</b></td>
					<td><select name="default_location_id">
					<?php foreach ($locations as $location) { ?>
					<?php if ($location['location_id'] === $default_location_id) { ?>
						<option value="<?php echo $location['location_id']; ?>" selected="selected"><?php echo $location['location_name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $location['location_id']; ?>"><?php echo $location['location_name']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><b>Site Description:</b></td>
					<td><textarea name="site_desc" cols="50" rows="7"><?php echo $site_desc; ?></textarea></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Limit Per Page:</b><br />
					<font size="1">Limit how many items are shown per page</font></td>
					<td><select name="page_limit">
					<?php foreach ($page_limits as $key => $value) { ?>
					<?php if ($value === $page_limit) { ?>
						<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
			</table>
		</div>	

		<div id="menu-list" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><b>Display Menu Images:</b><br />
					<font size="1">Show or hide menu images on view menu page</font></td>
					<td><select name="show_menu_images">
					<?php if ($show_menu_images === '1') { ?>
						<option value="1" selected="selected">Show</option>
						<option value="0">Hide</option>
					<?php } else { ?>
						<option value="1">Show</option>
						<option value="0" selected="selected">Hide</option>
					<?php } ?>
					</select></td>
				</tr>
				<tr>
					<td><b>Menu Images Size:</b><br />
					<font size="1">(Height x Width)</font></td>
					<td><input type="text" name="menu_images_h" value="<?php echo $menu_images_h; ?>" class="textfield" size="5" /> x 
						<input type="text" name="menu_images_w" value="<?php echo $menu_images_w; ?>" class="textfield" size="5" />
					</td>
				</tr>
				<tr>
					<td><b>Specials Category</b><br />
					<font size="1">Select the category for special menus</font></td>
					<td><select name="special_category_id">
					<?php foreach ($categories as $category) { ?>
					<?php if ($category['category_id'] === $special_category_id) { ?>
						<option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['category_name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
			</table>
		</div>

		<div id="location" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><b>Google Maps API Key</b></td>
					<td><input type="text" name="maps_api_key" value="<?php echo $maps_api_key; ?>" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Search By:</b></td>
					<td><select name="search_by">
					<?php foreach ($search_by_array as $key => $value) { ?>
					<?php if ($search_by === $key) { ?>
						<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
					</select></td>
				</tr>
				<tr>
					<td><b>Distance Unit:</b></td>
					<td><select name="distance_unit">
					<?php if ($distance_unit === 'km') { ?>
						<option value="mi">Miles</option>
						<option value="km" selected="selected">Kilometers</option>
					<?php } else if ($distance_unit === 'mi') { ?>
						<option value="mi" selected="selected">Miles</option>
						<option value="km">Kilometers</option>
					<?php } else { ?>
						<option value="mi">Miles</option>
						<option value="km">Kilometers</option>
					<?php } ?>
				</select></td>
				</tr>
				<tr>
					<td><b>Search Radius:</b><br />
					<font size="1">Set the GLOBAL search radius in miles or kilometers. This is used if location radius has no value.</font></td>
					<td><input type="text" name="search_radius" value="<?php echo set_value('search_radius', $search_radius); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Approve Reviews:</b><br />
					<font size="1">Approve new review entry automatically or manually</font></td>
					<td><select name="approve_reviews">
					<?php if ($approve_reviews === '1') { ?>
						<option value="0">Auto</option>
						<option value="1" selected="selected">Manual</option>
					<?php } else { ?>
						<option value="0" selected="selected">Auto</option>
						<option value="1">Manual</option>
					<?php } ?>
					</select></td>
				</tr>
				<tr>
					<td><b>Send Order Email:</b><br />
					<font size="1">Send a email to the location email when a new order is received</font></td>
					<td><select name="send_order_email">
					<?php if ($send_order_email === '1') { ?>
						<option value="1" selected="selected">Enabled</option>
						<option value="0">Disabled</option>
					<?php } else { ?>
						<option value="1">Enabled</option>
						<option value="0" selected="selected">Disabled</option>
					<?php } ?>
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Send Reservation Email:</b><br />
					<font size="1">Send a email to the location email when a new reservation is received</font></td>
					<td><select name="send_reserve_email">
					<?php if ($send_reserve_email === '1') { ?>
						<option value="1" selected="selected">Enabled</option>
						<option value="0">Disabled</option>
					<?php } else { ?>
						<option value="1">Enabled</option>
						<option value="0" selected="selected">Disabled</option>
					<?php } ?>
					</select></td>
				</tr>
			</table>
		</div>

		<div id="order" class="wrap_content" style="display:none;">
			<span>Global Setting for order when Location setting is not set</span>
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span> <b>New Order Status:</b><br />
					<font size="1">Order status when a new order is received</font></td>
					<td><select name="order_status_new">
					<?php foreach ($statuses as $status) { ?>
					<?php if ($status['status_id'] === $order_status_new) { ?>
						<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Complete Order Status:</b><br />
					<font size="1">Order status when an order is completed</font></td>
					<td><select name="order_status_complete">
					<?php foreach ($statuses as $status) { ?>
					<?php if ($status['status_id'] === $order_status_complete) { ?>
						<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Guest Order:</b><br />
					<font size="1">Allow customer to place an order without creating an account.</font></td>
					<td><select name="guest_order">
					<?php if ($guest_order === '1') { ?>
						<option value="1" selected="selected">Enabled</option>
						<option value="0">Disabled</option>
					<?php } else { ?>
						<option value="1">Enabled</option>
						<option value="0" selected="selected">Disabled</option>
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><b>Location Order:</b><br />
					<font size="1">Allow customer to place an order without selecting a restaurant location</font></td>
					<td><select name="location_order">
					<?php if ($location_order === '1') { ?>
						<option value="1" selected="selected">Enabled</option>
						<option value="0">Disabled</option>
					<?php } else { ?>
						<option value="1">Enabled</option>
						<option value="0" selected="selected">Disabled</option>
					<?php } ?>
					</td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Ready Time:</b><br />
					<font size="1">Set in minutes when an order will be delivered/collected after being placed</font></td>
					<td><input type="text" name="ready_time" value="<?php echo set_value('ready_time', $ready_time); ?>" class="textfield" size="5" /></td>
				</tr>
			</table>
		</div>

		<div id="registration" class="wrap_content" style="display:none;">
			<center>Coming Soon as new improvement</center>
		</div>

		<div id="reservation" class="wrap_content" style="display:none;">
			<span>Global Setting for reservation when Location setting is not set</span>
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span> <b>Reservation ID Prefix:</b><br />
					<font size="1">Use table name as prefix for reservation ID</font></td>
					<td><select name="reserve_prefix">
					<?php if ($reserve_prefix === '1') { ?>
						<option value="1" selected="selected">Enabled</option>
						<option value="0">Disabled</option>
					<?php } else { ?>
						<option value="1">Enabled</option>
						<option value="0" selected="selected">Disabled</option>
					<?php } ?>
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>New Reservation Status:</b><br />
					<font size="1">Reservation status when a new reservation is confirmed</font></td>
					<td><select name="reserve_status">
					<?php foreach ($statuses as $status) { ?>
					<?php if ($status['status_id'] === $reserve_status) { ?>
						<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Time Interval:</b><br />
					<font size="1">Set in minutes the time between each reservation</font></td>
					<td><input type="text" name="reserve_interval" value="<?php echo set_value('reserve_interval', $reserve_interval); ?>" size="3" class="textfield" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Turn Time:</b><br />
					<font size="1">Set in minutes the turn time for each reservation</font></td>
					<td><input type="text" name="reserve_turn" value="<?php echo set_value('reserve_turn', $reserve_turn); ?>" class="textfield" size="5" /></td>
				</tr>
			</table>
		</div>

		<div id="mail" class="wrap_content" style="display:none;">
			<span>Global Setting for sending out emails</span>
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span> <b>Mail Protocol:</b></td>
					<td><select name="protocol">
					<?php foreach ($protocals as $key => $value) { ?>
					<?php if ($value === $protocol) { ?>
						<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span> <b>Mail Type Format:</b></td>
					<td><select name="mailtype">
					<?php foreach ($mailtypes as $key => $value) { ?>
					<?php if ($value === $mailtype) { ?>
						<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><b>SMTP Host:</b></td>
					<td><input type="text" name="smtp_host" value="<?php echo $smtp_host; ?>" /></td>
				</tr>
				<tr>
					<td><b>SMTP Port:</b></td>
					<td><input type="text" name="smtp_port" value="<?php echo $smtp_port; ?>" size="10"/></td>
				</tr>
				<tr>
					<td><b>SMTP Username:</b></td>
					<td><input type="text" name="smtp_user" value="<?php echo $smtp_user; ?>" autocomplete="off" /></td>
				</tr>
				<tr>
					<td><b>SMTP Password:</b></td>
					<td><input type="password" name="smtp_pass" value="<?php echo $smtp_pass; ?>" autocomplete="off" /></td>
				</tr>
			</table>
		</div>

		<div id="log" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span> <b>Threshold Options:</b></td>
					<td><select name="log_threshold">
					<?php foreach ($thresholds as $key => $value) { ?>
					<?php if ($key == $log_threshold) { ?>
						<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><b>Log Path:</b><br />
					<font size="1">Leave BLANK to use default "application/logs/". Use a full server path with trailing slash.</font></td>
					<td><input type="text" name="log_path" value="<?php echo $log_path; ?>" /></td>
				</tr>
			</table>
		</div>
	
		<div id="security" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span> <b>Encryption Key</b><br />
					<font size="1">encryption key for storing session.</font></td>
					<td><input type="text" name="encryption_key" value="<?php echo $encryption_key; ?>" /></td>
				</tr>
			</table>
		</div>
	
	</div>
	</form>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.hours').timepicker({
		timeFormat: 'HH:mm',
	});
});
//--></script>
<script type="text/javascript"><!--
	$('#tabs a').tabs();
//--></script>
<script src="<?php echo base_url("assets/js/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
function imageUpload(field) {
	$('#image-manager').remove();
		
	var iframe_url = js_site_url + 'admin/image_manager?popup=iframe&field_id=' + encodeURIComponent(field);

	$('#container').prepend('<div id="image-manager" style="padding: 3px 0px 0px 0px;"><iframe src="'+ iframe_url +'" width="780" height="550" frameborder="0"></iframe></div>');
	
	$('.imagebox-btn').fancybox({	
		width: 900,
		height: 600,
 		href:"#image-manager",
		autoScale: false,
		afterClose: function() {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: js_site_url + 'admin/image_manager/resize?image=' + encodeURIComponent($('#' + field).attr('value')),
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