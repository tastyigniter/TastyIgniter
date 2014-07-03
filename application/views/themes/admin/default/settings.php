<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">General</a></li>
				<li><a href="#menus" data-toggle="tab">Menus</a></li>
				<li><a href="#location" data-toggle="tab">Location</a></li>
				<li><a href="#order" data-toggle="tab">Order</a></li>
				<li><a href="#reservation" data-toggle="tab">Reservation</a></li>
				<li><a href="#themes" data-toggle="tab">Themes</a></li>
				<li><a href="#mail" data-toggle="tab">Mail</a></li>
				<li><a href="#system" data-toggle="tab">System</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" enctype="multipart/form-data" />
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-site-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="site_name" id="input-site-name" class="form-control" value="<?php echo $site_name; ?>" />
							<?php echo form_error('site_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-site-email" class="col-sm-2 control-label">Email:</label>
						<div class="col-sm-5">
							<input type="text" name="site_email" id="input-site-email" class="form-control" value="<?php echo $site_email; ?>" autocomplete="off" />
							<?php echo form_error('site_email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-country" class="col-sm-2 control-label">Country:</label>
						<div class="col-sm-5">
							<select name="country_id" id="input-country" class="form-control">
								<?php foreach ($countries as $country) { ?>
								<?php if ($country['country_id'] === $country_id) { ?>
									<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('country_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-timezone" class="col-sm-2 control-label">Timezone:</label>
						<div class="col-sm-5">
							<select name="timezone" id="" class="form-control">
								<?php foreach ($timezones as $key => $value) { ?>
								<?php if ($key === $timezone) { ?>
									<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<span class="help-block">Current UTC Time: <?php echo $current_time; ?></span>
							<?php echo form_error('timezone', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-currency" class="col-sm-2 control-label">Currency:</label>
						<div class="col-sm-5">
							<select name="currency_id" id="input-currency" class="form-control">
								<?php foreach ($currencies as $currency) { ?>
								<?php if ($currency['currency_id'] === $currency_id) { ?>
									<option value="<?php echo $currency['currency_id']; ?>" selected="selected"><?php echo $currency['currency_name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['currency_name']; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('currency_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-language" class="col-sm-2 control-label">Language:</label>
						<div class="col-sm-5">
							<select name="language_id" id="input-language" class="form-control">
								<?php foreach ($languages as $language) { ?>
								<?php if ($language['language_id'] === $language_id) { ?>
									<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('language_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-default-location" class="col-sm-2 control-label">Default Location:</label>
						<div class="col-sm-5">
							<select name="default_location_id" id="input-default-location" class="form-control">
								<?php foreach ($locations as $location) { ?>
								<?php if ($location['location_id'] === $default_location_id) { ?>
									<option value="<?php echo $location['location_id']; ?>" selected="selected"><?php echo $location['location_name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $location['location_id']; ?>"><?php echo $location['location_name']; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('default_location_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-customer-group" class="col-sm-2 control-label">Customer Group:</label>
						<div class="col-sm-5">
							<select name="customer_group_id" id="input-customer-group" class="form-control">
								<?php foreach ($customer_groups as $customer_group) { ?>
								<?php if ($customer_group['customer_group_id'] === $customer_group_id) { ?>
									<option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id'], TRUE); ?> ><?php echo $customer_group['group_name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id']); ?> ><?php echo $customer_group['group_name']; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('customer_group_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Logo:</label>
						<div class="col-sm-5">
							<div class="thumbnail imagebox" id="selectImage">
								<div class="preview">
									<img src="<?php echo $site_logo; ?>" class="thumb img-responsive" id="thumb" />
								</div>
								<div class="caption">
									<center class="name"><?php echo $logo_name; ?></center>
									<input type="hidden" name="site_logo" value="<?php echo set_value('site_logo', $logo_val); ?>" id="field" />
									<p>
										<a id="select-image" class="btn btn-select-image" onclick="imageUpload('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>
										<a class="btn btn-times" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('center').html('no_photo.png');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove</a>
									</p>
								</div>
							</div>
							<?php echo form_error('site_logo', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-site-desc" class="col-sm-2 control-label">Site Description:</label>
						<div class="col-sm-5">
							<textarea name="site_desc" id="input-site-desc" class="form-control" rows="7"><?php echo $site_desc; ?></textarea>
							<?php echo form_error('site_desc', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-page-limit" class="col-sm-2 control-label">Limit Per Page:
							<span class="help-block">Limit how many items are shown per page</span>
						</label>
						<div class="col-sm-5">
							<select name="page_limit" id="input-page-limit" class="form-control">
								<?php foreach ($page_limits as $key => $value) { ?>
								<?php if ($value === $page_limit) { ?>
									<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('page_limit', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>	

				<div id="menus" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-show-menu-images" class="col-sm-2 control-label">Display Menu Images:
							<span class="help-block">Show or hide menu images on view menu page</span>
						</label>
						<div class="col-sm-5">
							<select name="show_menu_images" id="input-show-menu-images" class="form-control">
								<?php if ($show_menu_images === '1') { ?>
									<option value="1" selected="selected">Show</option>
									<option value="0">Hide</option>
								<?php } else { ?>
									<option value="1">Show</option>
									<option value="0" selected="selected">Hide</option>
								<?php } ?>
							</select>
							<?php echo form_error('show_menu_images', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-menu-images-h" class="col-sm-2 control-label">Menu Images Size:
							<span class="help-block">(Height x Width)</span>
						</label>
						<div class="form-mini col-sm-5">
							<div class="col-sm-2">
								<input type="text" name="menu_images_h" id="input-menu-images-h" class="form-control" value="<?php echo $menu_images_h; ?>" />
							</div>
							<div class="col-sm-2">
								<input type="text" name="menu_images_w" id="" class="form-control" value="<?php echo $menu_images_w; ?>" class="mini" />
							</div>
							<?php echo form_error('menu_images_h', '<span class="text-danger">', '</span>'); ?>
							<?php echo form_error('menu_images_w', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-special-category" class="col-sm-2 control-label">Specials Category
							<span class="help-block">Select which category to use automatically for special menus</span>
						</label>
						<div class="col-sm-5">
							<select name="special_category_id" id="input-special-category" class="form-control">
								<?php foreach ($categories as $category) { ?>
								<?php if ($category['category_id'] === $special_category_id) { ?>
									<option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['category_name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('special_category_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="location" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-maps-api-key" class="col-sm-2 control-label">Google Maps API Key</label>
						<div class="col-sm-5">
							<input type="text" name="maps_api_key" id="input-maps-api-key" class="form-control" value="<?php echo $maps_api_key; ?>" />
							<?php echo form_error('maps_api_key', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-search-by" class="col-sm-2 control-label">Search By:</label>
						<div class="col-sm-5">
							<select name="search_by" id="input-search-by" class="form-control">
								<?php foreach ($search_by_array as $key => $value) { ?>
								<?php if ($search_by === $key) { ?>
									<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
								<?php } else { ?>
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('search_by', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-distance-unit" class="col-sm-2 control-label">Distance Unit:</label>
						<div class="col-sm-5">
							<select name="distance_unit" id="input-distance-unit" class="form-control">
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
							</select>
							<?php echo form_error('distance_unit', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-search-radius" class="col-sm-2 control-label">Search Radius:
							<span class="help-block">Set the GLOBAL search radius in miles or kilometers. This is used if location radius has no value.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="search_radius" id="input-search-radius" class="form-control" value="<?php echo set_value('search_radius', $search_radius); ?>" />
							<?php echo form_error('search_radius', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-approve-reviews" class="col-sm-2 control-label">Approve Reviews:
							<span class="help-block">Approve new review entry automatically or manually</span>
						</label>
						<div class="col-sm-5">
							<select name="approve_reviews" id="input-approve-reviews" class="form-control">
								<?php if ($approve_reviews === '1') { ?>
									<option value="0">Auto</option>
									<option value="1" selected="selected">Manual</option>
								<?php } else { ?>
									<option value="0" selected="selected">Auto</option>
									<option value="1">Manual</option>
								<?php } ?>
							</select>
							<?php echo form_error('approve_reviews', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-send-order-email" class="col-sm-2 control-label">Send Order Email:
							<span class="help-block">Send a email to the location email when a new order is received</span>
						</label>
						<div class="col-sm-5">
							<select name="send_order_email" id="input-send-order-email" class="form-control">
								<?php if ($send_order_email === '1') { ?>
									<option value="1" selected="selected">Enabled</option>
									<option value="0">Disabled</option>
								<?php } else { ?>
									<option value="1">Enabled</option>
									<option value="0" selected="selected">Disabled</option>
								<?php } ?>
							</select>
							<?php echo form_error('send_order_email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-send-reserve-email" class="col-sm-2 control-label">Send Reservation Email:
							<span class="help-block">Send a email to the location email when a new reservation is received</span>
						</label>
						<div class="col-sm-5">
							<select name="send_reserve_email" id="input-send-reserve-email" class="form-control">
								<?php if ($send_reserve_email === '1') { ?>
									<option value="1" selected="selected">Enabled</option>
									<option value="0">Disabled</option>
								<?php } else { ?>
									<option value="1">Enabled</option>
									<option value="0" selected="selected">Disabled</option>
								<?php } ?>
							</select>
							<?php echo form_error('send_reserve_email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="order" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-order-status-new" class="col-sm-2 control-label">New Order Status:
							<span class="help-block">Order status when a new order is received</span>
						</label>
						<div class="col-sm-5">
							<select name="order_status_new" id="input-order-status-new" class="form-control">
								<optgroup label="Orders">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'order') { ?>
										<?php if ($status['status_id'] === $order_status_new) { ?>
											<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
										<?php } else { ?>  
											<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
										<?php } ?> 
									<?php } ?>  
									<?php } ?>  
								</optgroup> 
								<optgroup label="Reservations">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'reserve') { ?>
										<?php if ($status['status_id'] === $order_status_new) { ?>
											<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
										<?php } else { ?>  
											<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
										<?php } ?> 
									<?php } ?>  
									<?php } ?>  
								</optgroup> 
							</select>
							<?php echo form_error('order_status_new', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-status-complete" class="col-sm-2 control-label">Complete Order Status:
							<span class="help-block">Order status when an order is completed</span>
						</label>
						<div class="col-sm-5">
							<select name="order_status_complete" id="input-order-status-complete" class="form-control">
								<optgroup label="Orders">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'order') { ?>
										<?php if ($status['status_id'] === $order_status_complete) { ?>
											<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
										<?php } else { ?>  
											<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
										<?php } ?> 
									<?php } ?>  
									<?php } ?>  
								</optgroup> 
								<optgroup label="Reservations">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'reserve') { ?>
										<?php if ($status['status_id'] === $order_status_complete) { ?>
											<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
										<?php } else { ?>  
											<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
										<?php } ?> 
									<?php } ?>  
									<?php } ?>  
								</optgroup> 
							</select>
							<?php echo form_error('order_status_complete', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-guest-order" class="col-sm-2 control-label">Guest Order:
							<span class="help-block">Allow customer to place an order without creating an account.</span>
						</label>
						<div class="col-sm-5">
							<select name="guest_order" id="input-guest-order" class="form-control">
								<?php if ($guest_order === '1') { ?>
									<option value="1" selected="selected">Enabled</option>
									<option value="0">Disabled</option>
								<?php } else { ?>
									<option value="1">Enabled</option>
									<option value="0" selected="selected">Disabled</option>
								<?php } ?>  
							</select>
							<?php echo form_error('guest_order', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-location-order" class="col-sm-2 control-label">Location Order:
							<span class="help-block">DO NOT allow customer to place an order without selecting a restaurant location</span>
						</label>
						<div class="col-sm-5">
							<select name="location_order" id="input-location-order" class="form-control">
								<?php if ($location_order === '1') { ?>
									<option value="1" selected="selected">Enabled</option>
									<option value="0">Disabled</option>
								<?php } else { ?>
									<option value="1">Enabled</option>
									<option value="0" selected="selected">Disabled</option>
								<?php } ?>
							</select>
							<?php echo form_error('location_order', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-ready-time" class="col-sm-2 control-label">Ready Time:
							<span class="help-block">Set in minutes when an order will be delivered/collected after being placed</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="ready_time" id="input-ready-time" class="form-control" value="<?php echo set_value('ready_time', $ready_time); ?>" />
							<?php echo form_error('ready_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="reservation" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-reserve-mode" class="col-sm-2 control-label">Reservation Mode:
							<span class="help-block">Enabled or disabled table reservation in store front.</span>
						</label>
						<div class="col-sm-5">
							<select name="reservation_mode" id="input-reserve-mode" class="form-control">
								<?php if ($reservation_mode === '1') { ?>
									<option value="1" selected="selected">Enabled</option>
									<option value="0">Disabled</option>
								<?php } else { ?>
									<option value="1">Enabled</option>
									<option value="0" selected="selected">Disabled</option>
								<?php } ?>
							</select>
							<?php echo form_error('reservation_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-status" class="col-sm-2 control-label">New Reservation Status:
							<span class="help-block">Reservation status when a new reservation is confirmed</span>
						</label>
						<div class="col-sm-5">
							<select name="reservation_status" id="input-reserve-status" class="form-control">
								<optgroup label="Orders">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'order') { ?>
										<?php if ($status['status_id'] === $reservation_status) { ?>
											<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
										<?php } else { ?>  
											<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
										<?php } ?> 
									<?php } ?>  
									<?php } ?>  
								</optgroup> 
								<optgroup label="Reservations">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'reserve') { ?>
										<?php if ($status['status_id'] === $reservation_status) { ?>
											<option value="<?php echo $status['status_id']; ?>" selected="selected"><?php echo $status['status_name']; ?></option>
										<?php } else { ?>  
											<option value="<?php echo $status['status_id']; ?>"><?php echo $status['status_name']; ?></option>
										<?php } ?> 
									<?php } ?>  
									<?php } ?>  
								</optgroup> 
							</select>
							<?php echo form_error('reservation_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-interval" class="col-sm-2 control-label">Time Interval:
							<span class="help-block">Set in minutes the time between each reservation</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="reservation_interval" id="input-reserve-interval" class="form-control" value="<?php echo set_value('reservation_interval', $reservation_interval); ?>" />
							<?php echo form_error('reservation_interval', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-turn" class="col-sm-2 control-label">Turn Time:
							<span class="help-block">Set in minutes the turn time for each reservation</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="reservation_turn" id="input-reserve-turn" class="form-control" value="<?php echo set_value('reservation_turn', $reservation_turn); ?>" />
							<?php echo form_error('reservation_turn', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="themes" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-themes-allowed-img" class="col-sm-2 control-label">Allowed Image Extensions:
							<span class="help-block">List of extensions allowed to be uploaded separated with “|”. e.g png|jpg</span>
						</label>
						<div class="col-sm-5">
							<textarea name="themes_allowed_img" id="input-themes-allowed-img" class="form-control" rows="3"><?php echo set_value('themes_allowed_img', $themes_allowed_img); ?></textarea>
							<?php echo form_error('themes_allowed_img', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-themes-allowed-file" class="col-sm-2 control-label">Allowed File Extensions:
							<span class="help-block">List of extensions allowed to be uploaded separated with “|”. e.g css|php</span>
						</label>
						<div class="col-sm-5">
							<textarea name="themes_allowed_file" id="input-themes-allowed-file" class="form-control" rows="3"><?php echo set_value('themes_allowed_file', $themes_allowed_file); ?></textarea>
							<?php echo form_error('themes_allowed_file', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-themes-hidden-files" class="col-sm-2 control-label">Hidden Files:
							<span class="help-block">List of files to hide separated with “|”. e.g file1.jpg|file2.txt</span>
						</label>
						<div class="col-sm-5">
							<textarea name="themes_hidden_files" id="input-themes-hidden-files" class="form-control" rows="5"><?php echo set_value('themes_hidden_files', $themes_hidden_files); ?></textarea>
							<?php echo form_error('themes_hidden_files', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-themes-hidden-folders" class="col-sm-2 control-label">Hidden Folders:
							<span class="help-block">List of folders to hide separated with “|”. e.g folder1|folder2</span>
						</label>
						<div class="col-sm-5">
							<textarea name="themes_hidden_folders" id="input-themes-hidden-folders" class="form-control" rows="5"><?php echo set_value('themes_hidden_folders', $themes_hidden_folders); ?></textarea>
							<?php echo form_error('themes_hidden_folders', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="mail" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-protocol" class="col-sm-2 control-label">Mail Protocol:</label>
						<div class="col-sm-5">
							<select name="protocol" id="input-protocol" class="form-control">
								<?php foreach ($protocals as $key => $value) { ?>
								<?php if ($value === $protocol) { ?>
									<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('protocol', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-mailtype" class="col-sm-2 control-label">Mail Type Format:</label>
						<div class="col-sm-5">
							<select name="mailtype" id="input-mailtype" class="form-control">
								<?php foreach ($mailtypes as $key => $value) { ?>
								<?php if ($value === $mailtype) { ?>
									<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('mailtype', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-smtp-host" class="col-sm-2 control-label">SMTP Host:</label>
						<div class="col-sm-5">
							<input type="text" name="smtp_host" id="input-smtp-host" class="form-control" value="<?php echo $smtp_host; ?>" />
							<?php echo form_error('smtp_host', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-smtp-port" class="col-sm-2 control-label">SMTP Port:</label>
						<div class="col-sm-5">
							<input type="text" name="smtp_port" id="input-smtp-port" class="form-control" value="<?php echo $smtp_port; ?>" />
							<?php echo form_error('smtp_port', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-smtp-user" class="col-sm-2 control-label">SMTP Username:</label>
						<div class="col-sm-5">
							<input type="text" name="smtp_user" id="input-smtp-user" class="form-control" value="<?php echo $smtp_user; ?>" autocomplete="off" />
							<?php echo form_error('smtp_user', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-smtp-pass" class="col-sm-2 control-label">SMTP Password:</label>
						<div class="col-sm-5">
							<input type="password" name="smtp_pass" id="input-smtp-pass" class="form-control" value="<?php echo $smtp_pass; ?>" autocomplete="off" />
							<?php echo form_error('smtp_pass', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="system" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-log-threshold" class="col-sm-2 control-label">Logging:</label>
						<div class="col-sm-5">
							<select name="log_threshold" id="input-log-threshold" class="form-control">
								<?php foreach ($thresholds as $key => $value) { ?>
								<?php if ($key == $log_threshold) { ?>
									<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('log_threshold', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-log-path" class="col-sm-2 control-label">Log Path:
							<span class="help-block">Leave BLANK to use default "application/logs/". Use a full server path with trailing slash.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="log_path" id="input-log-path" class="form-control" value="<?php echo $log_path; ?>" />
							<?php echo form_error('log_path', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-encryption-key" class="col-sm-2 control-label">Encryption Key:
							<span class="help-block">Enter a secret key that will be used to encrypt data.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="encryption_key" id="input-encryption-key" class="form-control" value="<?php echo $encryption_key; ?>" />
							<?php echo form_error('encryption_key', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-index-file-url" class="col-sm-2 control-label">Index file:
							<span class="help-block">Display the index.php in URL</span>
						</label>
						<div class="col-sm-5">
							<select name="index_file_url" id="input-index-file-url" class="form-control">
								<?php if ($index_file_url === '1') { ?>
									<option value="1" selected="selected">Hide</option>
									<option value="0">Show</option>
								<?php } else { ?>
									<option value="1">Hide</option>
									<option value="0" selected="selected">Show</option>
								<?php } ?>
							</select>
							<?php echo form_error('index_file_url', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-permalink" class="col-sm-2 control-label">Permalink:</label>
						<div class="col-sm-5">
							<select name="permalink" id="input-permalink" class="form-control">
								<?php if ($permalink === '1') { ?>
									<option value="1" selected="selected">Enabled</option>
									<option value="0">Disabled</option>
								<?php } else { ?>
									<option value="1">Enabled</option>
									<option value="0" selected="selected">Disabled</option>
								<?php } ?>
							</select>
							<?php echo form_error('permalink', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-activity-timeout" class="col-sm-2 control-label">Activity Timeout:
							<span class="help-block">The number of seconds a customer activity will last. Seconds must be more than 120 seconds</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="activity_timeout" id="input-activity-timeout" class="form-control" value="<?php echo $activity_timeout; ?>" />
							<?php echo form_error('activity_timeout', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-activity-delete" class="col-sm-2 control-label">Activity Delete:
							<span class="help-block">Delete all activities older than</span>
						</label>
						<div class="col-sm-5">
							<select name="activity_delete" id="input-activity-delete" class="form-control">
								<?php if ($activity_delete === '1') { ?>
									<option value="0">Never delete</option>
									<option value="1" selected="selected">1 month</option>
									<option value="3">3 months</option>
									<option value="6">6 months</option>
									<option value="12">12 months</option>
								<?php } else if ($activity_delete === '3') { ?>
									<option value="0">Never delete</option>
									<option value="1">1 month</option>
									<option value="3" selected="selected">3 months</option>
									<option value="6">6 months</option>
									<option value="12">12 months</option>
								<?php } else if ($activity_delete === '6') { ?>
									<option value="0">Never delete</option>
									<option value="1">1 month</option>
									<option value="3">3 months</option>
									<option value="6" selected="selected">6 months</option>
									<option value="12">12 months</option>
								<?php } else if ($activity_delete === '12') { ?>
									<option value="0">Never delete</option>
									<option value="1">1 month</option>
									<option value="3">3 months</option>
									<option value="6">6 months</option>
									<option value="12" selected="selected">12 months</option>
								<?php } else { ?>
									<option value="0" selected="selected">Never delete</option>
									<option value="1">1 month</option>
									<option value="3">3 months</option>
									<option value="6">6 months</option>
									<option value="12">12 months</option>
								<?php } ?>
							</select>
							<?php echo form_error('activity_delete', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-maintenance-mode" class="col-sm-2 control-label">Maintenance Mode:
							<span class="help-block">Enable if you want to display a maintenance page to customers except logged in admin.</span>
						</label>
						<div class="col-sm-5">
							<select name="maintenance_mode" id="input-maintenance-mode" class="form-control">
								<?php if ($maintenance_mode === '1') { ?>
									<option value="1" selected="selected">Enabled</option>
									<option value="0">Disabled</option>
								<?php } else { ?>
									<option value="1">Enabled</option>
									<option value="0" selected="selected">Disabled</option>
								<?php } ?>
							</select>
							<?php echo form_error('maintenance_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-maintenance-page" class="col-sm-2 control-label">Maintenance Page:</label>
						<div class="col-sm-5">
							<select name="maintenance_page" id="input-maintenance-page" class="form-control">
								<?php foreach ($pages as $page) { ?>
								<?php if ($page['page_id'] === $maintenance_page) { ?>
									<option value="<?php echo $page['page_id']; ?>" selected="selected"><?php echo $page['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $page['page_id']; ?>"><?php echo $page['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('maintenance_page', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-cache-mode" class="col-sm-2 control-label">Cache Mode:
							<span class="help-block">Enable if you want to cache pages in order to achieve maximum performance.</span>
						</label>
						<div class="col-sm-5">
							<select name="cache_mode" id="input-cache-mode" class="form-control">
								<?php if ($cache_mode === '1') { ?>
									<option value="1" selected="selected">Enabled</option>
									<option value="0">Disabled</option>
								<?php } else { ?>
									<option value="1">Enabled</option>
									<option value="0" selected="selected">Disabled</option>
								<?php } ?>
							</select>
							<?php echo form_error('cache_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-cache-time" class="col-sm-2 control-label">Cache Time:
							<span class="help-block">Set the number of minutes a page remain cached.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="cache_time" id="input-cache-time" class="form-control" value="<?php echo $cache_time; ?>" />
							<?php echo form_error('cache_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.hours').timepicker({
		timeFormat: 'HH:mm',
	});
	
	if(window.location.hash) {
		var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
		$('#nav-tabs a[href="#'+hash+'"]').tab('show');
		// hash found
  	} else {
		// No hash found
  	}
});
//--></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/js/fancybox/jquery.fancybox.css"); ?>">
<script src="<?php echo base_url("assets/js/fancybox/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
function imageUpload(field) {
	$('#image-manager').remove();
		
	var iframe_url = js_site_url('admin/image_manager?popup=iframe&field_id=') + encodeURIComponent(field);

	$('body').append('<div id="image-manager" style="padding: 3px 0px 0px 0px;"><iframe src="'+ iframe_url +'" width="980" height="550" frameborder="0"></iframe></div>');
	
	$.fancybox({	
 		href:"#image-manager",
		autoScale: false,
		afterClose: function() {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: js_site_url('admin/image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'json',
					success: function(json) {
						var thumb = $('#' + field).parent().parent().find('.thumb');
						$(thumb).replaceWith('<img src="' + json + '" alt="" class="thumb" id="thumb" />');
					}
				});
			}
		}
	});
};
//--></script>
<?php echo $footer; ?>