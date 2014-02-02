<div class="box">
	<div id ="update-box" class="border_all">
	<h2 align="">GENERAL</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table align=""class="form">
		<tr>
    		<td><span class="red">*</span><b>Restaurant Name:</b></td>
    		<td><input type="text" name="config_site_name" value="<?php echo $config_site_name; ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><span class="red">*</span><b>Restaurant Email:</b></td>
    		<td><input type="text" name="config_site_email" value="<?php echo $config_site_email; ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><span class="red">*</span><b>Restaurant Country:</b></td>
    		<td><select name="config_country">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $config_country) { ?>
  				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><span class="red">*</span><b>Restaurant Timezone:</b></td>
    		<td><select name="config_timezone">
			<?php foreach ($timezones as $key => $value) { ?>
			<?php if ($key === $config_timezone) { ?>
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
    		<td><select name="config_currency">
			<?php foreach ($currencies as $currency) { ?>
			<?php if ($currency['currency_id'] === $config_currency) { ?>
  				<option value="<?php echo $currency['currency_id']; ?>" selected="selected"><?php echo $currency['currency_title']; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['currency_title']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><b>Site Description:</b></td>
    		<td><textarea name="config_site_desc" cols="50" rows="7"><?php echo $config_site_desc; ?></textarea></td>
		</tr>
		<tr>
    		<td><b>Default Limit Per Page:</b><br />
    		<font size="1">(Limit how many items are shown per page)</font></td>
    		<td><select name="config_page_limit">
			<?php foreach ($page_limits as $key => $value) { ?>
			<?php if ($value === $config_page_limit) { ?>
  				<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
		</tr>
	</table>
	
	<div class="wrap-heading">
		<h3 align="">REVIEW</h3>
	</div>
	
	<div class="wrap-content">
	<table align=""class="form">
		<tr>
			<td><span class="red">*</span><b>Approve Reviews:</b><br />
    		<font size="1">(Approve new review entry automatically or manually)</font></td>
    		<td><select name="config_approve_reviews">
	    	<?php if ($config_approve_reviews === '1') { ?>
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

	<div class="wrap-heading">
		<h3 align="">LOCATION</h3>
	</div>
	
	<div class="wrap-content">
	<table align=""class="form">
		<tr>
			<td><span class="red">*</span><b>Search By:</b></td>
    		<td><select name="config_search_by">
    		<?php foreach ($search_by as $key => $value) { ?>
	    	<?php if ($config_search_by === $key) { ?>
				<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
    		<?php } else { ?>
				<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
    		<?php } ?>
    		<?php } ?>
    		</select></td>
		</tr>
		<tr>
			<td><span class="red">*</span><b>Distance Unit:</b></td>
    		<td><select name="config_distance_unit">
	    	<?php if ($config_distance_unit === 'km') { ?>
				<option value="mi">Miles</option>
				<option value="km" selected="selected">Kilometers</option>
    		<?php } else if ($config_distance_unit === 'mi') { ?>
				<option value="mi" selected="selected">Miles</option>
				<option value="km">Kilometers</option>
    		<?php } else { ?>
 				<option value="mi">Miles</option>
				<option value="km">Kilometers</option>
    		<?php } ?>
   		</select></td>
		</tr>
		<tr>
    		<td><span class="red">*</span><b>Allow Order:</b><br />
    		<font size="1">Allow customer to order without selecting a location</font></td>
    		<td>
	    	<?php if ($config_allow_order === '1') { ?>
				<input type="radio" name="config_allow_order" value="1" checked="checked" /> Yes 
				<input type="radio" name="config_allow_order" value="0" /> No
    		<?php } else { ?>
				<input type="radio" name="config_allow_order" value="1"> Yes 
				<input type="radio" name="config_allow_order" value="0" checked="checked"> No 
    		<?php } ?>
    		</td>
		</tr>
	</table>
	</div>

	<div class="wrap-heading">
		<h3 align="">ORDER</h3>
	</div>
	
	<div class="wrap-content">
	<table align=""class="form">
		<tr>
    		<td><span class="red">*</span><b>Received Status:</b><br />
    		<font size="1">Default order status when an order is received</font></td>
    		<td><select name="config_order_received">
			<?php foreach ($statuses as $status) { ?>
			<?php if ($status['status_id'] === $config_order_received) { ?>
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
    		<td><select name="config_order_completed">
			<?php foreach ($statuses as $status) { ?>
			<?php if ($status['status_id'] === $config_order_completed) { ?>
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
    		<td><input type="text" name="config_ready_time" value="<?php echo set_value('config_ready_time', $config_ready_time); ?>" class="textfield" size="5" /> minutes</td>
		</tr>
	</table>
	</div>

	<div class="wrap-heading">
		<h3 align="">RESERVATION</h3>
	</div>
	
	<div class="wrap-content">
	<table align=""class="form">
		<tr>
    		<td><span class="red">*</span><b>Reservation Status:</b><br />
    		<font size="1">Default reservation status when a booking is reserved</font></td>
    		<td><select name="config_reserve_status">
			<?php foreach ($statuses as $status) { ?>
			<?php if ($status['status_id'] === $config_reserve_status) { ?>
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
    		<td><input type="text" name="config_reserve_interval" value="" size="3" class="textfield" /></td>
		</tr>
		<tr>
			<td><span class="red">*</span><b>Reservation ID Prefix:</b><br />
    		<font size="1">(Use table name as prefix for reservation ID)</font></td>
    		<td><select name="config_reserve_prefix">
	    	<?php if ($config_reserve_prefix === '1') { ?>
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

	<div class="wrap-heading">
		<h3 align="">IMAGE</h3>
	</div>
	
	<div class="wrap-content">
	<table align=""class="form">
		<tr>
    		<td><span class="red">*</span><b>Restaurant Logo:</b></td>
    		<td><div class="selectbox" style="height:100px">
			<table width="390">
				<tr>
					<th><b>Existing</b></th>
					<th><b>New</b></th>
				</tr>
				<tr>
					<td><img src="<?php echo $config_site_logo; ?>" width="80" height="70"></td>
					<td><input type="file" name="config_site_logo" value="" id="photo"/></td>
				</tr>
			</table>
			</div></td>
		</tr>
		<tr>
    		<td><span class="red">*</span><b>Upload Path:</b></td>
    		<td><input type="text" name="config_upload_path" value="<?php echo $config_upload_path; ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><span class="red">*</span><b>Allowed Types:</b></td>
    		<td><input type="text" name="config_allowed_types" value="<?php echo $config_allowed_types; ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><span class="red">*</span><b>Maximum File Size(kb):</b></td>
    		<td><input type="text" name="config_max_size" value="<?php echo $config_max_size; ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
    		<td><span class="red">*</span><b>Maximum Image Size:</b><br />
    		<font size="1">(H x W)</font></td>
    		<td><input type="text" name="config_max_height" value="<?php echo $config_max_height; ?>" class="textfield" size="5" /> x 
    			<input type="text" name="config_max_width" value="<?php echo $config_max_width; ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
    		<td><span class="red">*</span><b>Menus Image Size:</b><br />
    		<font size="1">(H x W)</font></td>
    		<td><input type="text" name="config_menus_height" value="<?php echo $config_menus_height; ?>" class="textfield" size="5" /> x 
    			<input type="text" name="config_menus_width" value="<?php echo $config_menus_width; ?>" class="textfield" size="5" /></td>
		</tr>
	</table>
	</div>

	<div class="wrap-heading">
		<h3 align="">EMAIL</h3>
	</div>
	
	<div class="wrap-content">
	<table align=""class="form">
		<tr>
    		<td><span class="red">*</span><b>Mail Protocol:</b></td>
            <td><select name="config_protocol">
            <?php foreach ($protocals as $key => $value) { ?>
            <?php if ($value === $config_protocol) { ?>
  				<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
		</tr>
        <tr>
            <td><span class="red">*</span><b>Mail Type Format:</b></td>
            <td><select name="config_mailtype">
            <?php foreach ($mailtypes as $key => $value) { ?>
            <?php if ($value === $config_mailtype) { ?>
  				<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
        </tr>
        <tr>
          	<td><span class="red">*</span><b>SMTP Host:</b></td>
            <td><input type="text" name="config_smtp_host" value="<?php echo $config_smtp_host; ?>" /></td>
        </tr>
        <tr>
            <td><b>SMTP Port:</b></td>
            <td><input type="text" name="config_smtp_port" value="<?php echo $config_smtp_port; ?>" size="10"/></td>
        </tr>
        <tr>
            <td><b>SMTP Username:</b></td>
            <td><input type="text" name="config_smtp_user" value="<?php echo $config_smtp_user; ?>" /></td>
        </tr>
        <tr>
            <td><b>SMTP Password:</b></td>
            <td><input type="password" name="config_smtp_pass" value="<?php echo $config_smtp_pass; ?>" /></td>
        </tr>
	</table>
	</div>

	<div class="wrap-heading">
		<h3 align="">ERROR LOGGING</h3>
	</div>
	
	<div class="wrap-content">
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
	
	</div>
	</form>
</div>