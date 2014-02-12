<div class="box">
	<div id ="update-box" class="border_all">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" enctype="multipart/form-data" />
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">General</a></li>
				<li><a rel="#location">Location</a></li>
				<li><a rel="#review">Review</a></li>
				<li><a rel="#order">Order</a></li>
				<li><a rel="#reservation">Reservation</a></li>
				<li><a rel="#upload">Upload</a></li>
				<li><a rel="#mail">Mail</a></li>
				<li><a rel="#log">Log</a></li>
				<li><a rel="#security">Security</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span><b>Restaurant Name:</b></td>
					<td><input type="text" name="site_name" value="<?php echo $site_name; ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Restaurant Logo:</b></td>
					<td><div class="selectbox" style="height:100px">
					<table width="390">
						<tr>
							<th><b>Existing</b></th>
							<th><b>New</b></th>
						</tr>
						<tr>
							<td><img src="<?php echo $site_logo; ?>" width="80" height="70"></td>
							<td><input type="file" name="site_logo" value="" id="photo" /></td>
						</tr>
					</table>
					</div></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Restaurant Email:</b></td>
					<td><input type="text" name="site_email" value="<?php echo $site_email; ?>" class="textfield" autocomplete="off" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Restaurant Country:</b></td>
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
					<td><span class="red">*</span><b>Restaurant Timezone:</b></td>
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
					<td><span class="red">*</span><b>Set Default Currency:</b><br />
					<font size="1">Default:</font></td>
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
					<td><b>Site Description:</b></td>
					<td><textarea name="site_desc" cols="50" rows="7"><?php echo $site_desc; ?></textarea></td>
				</tr>
				<tr>
					<td><b>Default Limit Per Page:</b><br />
					<font size="1">(Limit how many items are shown per page)</font></td>
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

		<div id="location" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span><b>Search By:</b></td>
					<td><select name="search_by">
					<?php foreach ($search_by as $key => $value) { ?>
					<?php if ($search_by === $key) { ?>
						<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Distance Unit:</b></td>
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
					<td><span class="red">*</span><b>Allow Menu Selection:</b><br />
					<font size="1">Allow menu selection whether location is selected or not.</font></td>
					<td>
					<?php if ($allow_order === '1') { ?>
						<input type="radio" name="allow_order" value="1" checked="checked" /> Yes 
						<input type="radio" name="allow_order" value="0" /> No
					<?php } else { ?>
						<input type="radio" name="allow_order" value="1"> Yes 
						<input type="radio" name="allow_order" value="0" checked="checked"> No 
					<?php } ?>
					</td>
				</tr>
			</table>
		</div>

		<div id="review" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span><b>Approve Reviews:</b><br />
					<font size="1">(Approve new review entry automatically or manually)</font></td>
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
			</table>
		</div>

		<div id="order" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span><b>Received Status:</b><br />
					<font size="1">Default order status when an order is received</font></td>
					<td><select name="order_received">
					<?php foreach ($statuses as $status) { ?>
					<?php if ($status['status_id'] === $order_received) { ?>
						<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Complete Status:</b><br />
					<font size="1">Default order status when an order is completed</font></td>
					<td><select name="order_completed">
					<?php foreach ($statuses as $status) { ?>
					<?php if ($status['status_id'] === $order_completed) { ?>
						<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><b>Ready Time:</b><br />
					<font size="1">(Set how many minutes before an order is delivered or ready for collection. This will be used when a location ready time is not set)</font></td>
					<td><input type="text" name="ready_time" value="<?php echo set_value('ready_time', $ready_time); ?>" class="textfield" size="5" /> minutes</td>
				</tr>
			</table>
		</div>

		<div id="reservation" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span><b>Reservation Status:</b><br />
					<font size="1">Default reservation status when a booking is reserved</font></td>
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
					<td><span class="red">*</span><b>Reservation interval:</b><br />
					<font size="1">(Set the time between each reservation)</font></td>
					<td><input type="text" name="reserve_interval" value="" size="3" class="textfield" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Reservation ID Prefix:</b><br />
					<font size="1">(Use table name as prefix for reservation ID)</font></td>
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
			</table>
		</div>

		<div id="upload" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span><b>Upload Path:</b></td>
					<td><input type="text" name="upload_path" value="<?php echo $upload_path; ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Allowed Types:</b></td>
					<td><input type="text" name="allowed_types" value="<?php echo $allowed_types; ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Maximum File Size(kb):</b></td>
					<td><input type="text" name="max_size" value="<?php echo $max_size; ?>" class="textfield" size="5" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Maximum Image Size:</b><br />
					<font size="1">(H x W)</font></td>
					<td><input type="text" name="max_height" value="<?php echo $max_height; ?>" class="textfield" size="5" /> x 
						<input type="text" name="max_width" value="<?php echo $max_width; ?>" class="textfield" size="5" /></td>
				</tr>
				<tr>
					<td><span class="red">*</span><b>Menus Image Size:</b><br />
					<font size="1">(H x W)</font></td>
					<td><input type="text" name="menus_height" value="<?php echo $menus_height; ?>" class="textfield" size="5" /> x 
						<input type="text" name="menus_width" value="<?php echo $menus_width; ?>" class="textfield" size="5" /></td>
				</tr>
			</table>
		</div>

		<div id="mail" class="wrap_content" style="display:none;">
			<table align=""class="form">
				<tr>
					<td><span class="red">*</span><b>Mail Protocol:</b></td>
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
					<td><span class="red">*</span><b>Mail Type Format:</b></td>
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
					<td><span class="red">*</span><b>SMTP Host:</b></td>
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
					<td><span class="red">*</span><b>Threshold Options:</b></td>
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
					<td><span class="red">*</span><b>Encryption Key</b></td>
					<td><input type="text" name="encryption_key" value="<?php echo $encryption_key; ?>" /></td>
				</tr>
			</table>
		</div>
	
	</div>
	</form>
</div>
<script type="text/javascript"><!--
	$('#tabs a').tabs();
//--></script>