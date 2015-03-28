<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Location</a></li>
				<li><a href="#opening-hours" data-toggle="tab">Opening Hours</a></li>
				<li><a href="#order" data-toggle="tab">Order</a></li>
				<li><a href="#reservation" data-toggle="tab">Reservation</a></li>
				<li><a id="open-map" href="#delivery" data-toggle="tab">Delivery</a></li>
				<!--<li><a href="#options" data-toggle="tab">Options</a></li>-->
			</ul>
		</div>

		<form role="form" id="edit-form" name="edit_form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="location_name" id="input-name" class="form-control" value="<?php echo set_value('location_name', $location_name); ?>" />
							<?php echo form_error('location_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-address-1" class="col-sm-2 control-label">Address 1:</label>
						<div class="col-sm-5">
							<input type="text" name="address[address_1]" id="input-address-1" class="form-control" value="<?php echo set_value('address[address_1]', $location_address_1); ?>" />
							<?php echo form_error('address[address_1]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-address-2" class="col-sm-2 control-label">Address 2:</label>
						<div class="col-sm-5">
							<input type="text" name="address[address_2]" id="input-address-2" class="form-control" value="<?php echo set_value('address[address_2]', $location_address_2); ?>" />
							<?php echo form_error('address[address_2]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-city" class="col-sm-2 control-label">City:</label>
						<div class="col-sm-5">
							<input type="text" name="address[city]" id="input-city" class="form-control" value="<?php echo set_value('address[city]', $location_city); ?>" />
							<?php echo form_error('address[city]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-postcode" class="col-sm-2 control-label">Postcode:</label>
						<div class="col-sm-5">
							<input type="text" name="address[postcode]" id="input-postcode" class="form-control" value="<?php echo set_value('address[postcode]', $location_postcode); ?>" />
							<?php echo form_error('address[postcode]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-country" class="col-sm-2 control-label">Country:</label>
						<div class="col-sm-5">
							<select name="address[country]" id="input-country" class="form-control">
								<?php foreach ($countries as $country) { ?>
								<?php if ($country['country_id'] === $country_id) { ?>
									<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('address[country]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email" class="col-sm-2 control-label">Email:</label>
						<div class="col-sm-5">
							<input type="text" name="email" id="input-email" class="form-control" value="<?php echo set_value('email', $location_email); ?>" />
							<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-telephone" class="col-sm-2 control-label">Telephone:</label>
						<div class="col-sm-5">
							<input type="text" name="telephone" id="input-telephone" class="form-control" value="<?php echo set_value('telephone', $location_telephone); ?>" />
							<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-description" class="col-sm-2 control-label">Description:</label>
						<div class="col-sm-5">
							<textarea name="description" id="input-description" class="form-control" rows="5"><?php echo set_value('description', $description); ?></textarea>
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-slug" class="col-sm-2 control-label">Slug:
							<span class="help-block">Use ONLY alpha-numeric lowercase characters, underscores or dashes and make sure it is unique GLOBALLY.</span>
						</label>
						<div class="col-sm-5">
							<input type="hidden" name="permalink[permalink_id]" value="<?php echo set_value('permalink[permalink_id]', $permalink['permalink_id']); ?>"/>
							<input type="text" name="permalink[slug]" id="input-slug" class="form-control" value="<?php echo set_value('permalink[slug]', $permalink['slug']); ?>"/>
							<?php echo form_error('permalink[permalink_id]', '<span class="text-danger">', '</span>'); ?>
							<?php echo form_error('permalink[slug]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Status:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($location_status == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="location_status" value="0" <?php echo set_radio('location_status', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="location_status" value="1" <?php echo set_radio('location_status', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="location_status" value="0" <?php echo set_radio('location_status', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="location_status" value="1" <?php echo set_radio('location_status', '1'); ?>>Enabled</label>
								<?php } ?>
							</div>
							<?php echo form_error('location_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="opening-hours" class="tab-pane row wrap-all">
					<div id="opening-type" class="form-group">
						<label for="" class="col-sm-2 control-label">Type:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
								<?php if ($opening_type == '24_7') { ?>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="opening_type" value="24_7" <?php echo set_radio('opening_type', '24_7', TRUE); ?>>24/7</label>
								<?php } else { ?>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="opening_type" value="24_7" <?php echo set_radio('opening_type', '24_7'); ?>>24/7</label>
								<?php } ?>
								<?php if ($opening_type == 'daily') { ?>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="opening_type" value="daily" <?php echo set_radio('opening_type', 'daily', TRUE); ?>>Daily</label>
								<?php } else { ?>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="opening_type" value="daily" <?php echo set_radio('opening_type', 'daily'); ?>>Daily</label>
								<?php } ?>
								<?php if ($opening_type == 'flexible') { ?>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="opening_type" value="flexible" <?php echo set_radio('opening_type', 'flexible', TRUE); ?>>Flexible</label>
								<?php } else { ?>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="opening_type" value="flexible" <?php echo set_radio('opening_type', 'flexible'); ?>>Flexible</label>
								<?php } ?>
							</div>
							<?php echo form_error('opening_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<br />

					<div id="opening-daily">
						<div class="form-group">
							<label for="input-opening-days" class="col-sm-2 control-label">Days:</label>
							<div class="col-sm-5">
								<div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
									<?php foreach ($weekdays_abbr as $key => $value) { ?>
										<?php if (in_array($key, $daily_days)) { ?>
											<label class="btn btn-default active" data-btn="btn-success"><input type="checkbox" name="daily_days[]" value="<?php echo $key; ?>" <?php echo set_checkbox('daily_days[]', $key, TRUE); ?>><?php echo $value; ?></label>
										<?php } else { ?>
											<label class="btn btn-default" data-btn="btn-success"><input type="checkbox" name="daily_days[]" value="<?php echo $key; ?>" <?php echo set_checkbox('daily_days[]', $key); ?>><?php echo $value; ?></label>
										<?php } ?>
									<?php } ?>
								</div>
								<?php echo form_error('daily_days[]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-opening-hours" class="col-sm-2 control-label">Hours:</label>
							<div class="col-sm-5">
								<div class="control-group control-group-2">
									<div class="input-group">
										<input type="text" name="daily_hours[open]" class="form-control timepicker" value="<?php echo set_value('daily_hours[open]', $daily_hours['open']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="input-group">
										<input type="text" name="daily_hours[close]" class="form-control timepicker" value="<?php echo set_value('daily_hours[close]', $daily_hours['close']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
								</div>
								<?php echo form_error('daily_hours[open]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('daily_hours[close]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>

					<div id="opening-flexible">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-5">
								<div class="control-group control-group-2">
									<div class="input-group">
										<b>Open hour</b>
									</div>
									<div class="input-group">
										<b>Close hour</b>
									</div>
								</div>
							</div>
						</div>
						<?php foreach ($flexible_hours as $hour) { ?>
						<div class="form-group">
							<label for="input-status" class="col-sm-2 control-label text-right">
								<span class="text-right"><?php echo (isset($weekdays[$hour['day']])) ? $weekdays[$hour['day']] : $hour['day']; ?></span>
								<input type="hidden" name="flexible_hours[<?php echo $hour['day']; ?>][day]" value="<?php echo set_value('flexible_hours['.$hour['day'].'][day]', $hour['day']); ?>" />
							</label>
							<div class="col-sm-7">
								<div class="control-group control-group-3">
									<div class="input-group">
										<input type="text" name="flexible_hours[<?php echo $hour['day']; ?>][open]" class="form-control timepicker" value="<?php echo set_value('flexible_hours['.$hour['day'].'][open]', $hour['open']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="input-group">
										<input type="text" name="flexible_hours[<?php echo $hour['day']; ?>][close]" class="form-control timepicker" value="<?php echo set_value('flexible_hours['.$hour['day'].'][close]', $hour['close']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="btn-group btn-group-toggle" data-toggle="buttons">
										<?php if ($hour['status'] == '1') { ?>
											<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="flexible_hours[<?php echo $hour['day']; ?>][status]" value="0" <?php echo set_radio('flexible_hours['.$hour['day'].'][status]', '0'); ?>>Open</label>
											<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="flexible_hours[<?php echo $hour['day']; ?>][status]" value="1" checked="checked" <?php echo set_radio('flexible_hours['.$hour['day'].'][status]', '1'); ?>>Closed</label>
										<?php } else { ?>
											<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="flexible_hours[<?php echo $hour['day']; ?>][status]" value="0" checked="checked" <?php echo set_radio('flexible_hours['.$hour['day'].'][status]', '0'); ?>>Open</label>
											<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="flexible_hours[<?php echo $hour['day']; ?>][status]" value="1" <?php echo set_radio('flexible_hours['.$hour['day'].'][status]', '1'); ?>>Closed</label>
										<?php } ?>
									</div>
								</div>
								<?php echo form_error('flexible_hours['.$hour['day'].'][open]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('flexible_hours['.$hour['day'].'][close]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('flexible_hours['.$hour['day'].'][status]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>

				<div id="order" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-offer-delivery" class="col-sm-2 control-label">Offer Delivery:</label>
						<div class="col-sm-5">
							<div id="input-offer-delivery" class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($offer_delivery == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="offer_delivery" value="0" <?php echo set_radio('offer_delivery', '0'); ?>>No</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="offer_delivery" value="1" <?php echo set_radio('offer_delivery', '1', TRUE); ?>>Yes</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="offer_delivery" value="0" <?php echo set_radio('offer_delivery', '0', TRUE); ?>>No</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="offer_delivery" value="1" <?php echo set_radio('offer_delivery', '1'); ?>>Yes</label>
								<?php } ?>
							</div>
							<?php echo form_error('offer_delivery', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-offer-collection" class="col-sm-2 control-label">Offer Collection:</label>
						<div class="col-sm-5">
							<div id="input-offer-collection" class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($offer_collection == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="offer_collection" value="0" <?php echo set_radio('offer_collection', '0'); ?>>No</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="offer_collection" value="1" <?php echo set_radio('offer_collection', '1', TRUE); ?>>Yes</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="offer_collection" value="0" <?php echo set_radio('offer_collection', '0', TRUE); ?>>No</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="offer_collection" value="1" <?php echo set_radio('offer_collection', '1'); ?>>Yes</label>
								<?php } ?>
							</div>
							<?php echo form_error('offer_collection', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-delivery-time" class="col-sm-2 control-label">Delivery Time:
							<span class="help-block">Set number of minutes an order will be delivered after being placed</span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="delivery_time" id="input-delivery-time" class="form-control" value="<?php echo set_value('delivery_time', $delivery_time); ?>" />
								<span class="input-group-addon">minutes</span>
							</div>
							<?php echo form_error('delivery_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-collection-time" class="col-sm-2 control-label">Collection Time:
							<span class="help-block">Set number of minutes an order will be ready for collection after being placed</span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="collection_time" id="input-collection-time" class="form-control" value="<?php echo set_value('collection_time', $collection_time); ?>" />
								<span class="input-group-addon">minutes</span>
							</div>
							<?php echo form_error('collection_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-last-order-time" class="col-sm-2 control-label">Last Order Time:
							<span class="help-block">Set number of minutes before closing time for last order. Leave blank to use closing hour.</span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="last_order_time" id="input-last-order-time" class="form-control" value="<?php echo set_value('last_order_time', $last_order_time); ?>" />
								<span class="input-group-addon">minutes</span>
							</div>
							<?php echo form_error('last_order_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-payments" class="col-sm-2 control-label">Payments:
							<span class="help-block">Select the payment(s) available at this location. Do not select anything to use all enabled payments</span>
						</label>
						<div class="col-sm-5">
							<select name="payments[]" id="input-payments" class="form-control" multiple="multiple">
								<?php foreach ($payment_list as $payment) { ?>
								<?php if (in_array($payment['code'], $payments)) { ?>
									<option value="<?php echo $payment['code']; ?>" selected="selected"><?php echo $payment['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $payment['code']; ?>"><?php echo $payment['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('payments[]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!--<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Latitude:</label>
						<div class="col-sm-5">
							<?php echo $location_lat; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Longitude:</label>
						<div class="col-sm-5">
							<?php echo $location_lng; ?>
						</div>
					</div>-->
				</div>

				<div id="reservation" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-table" class="col-sm-2 control-label">Tables:</label>
						<div class="col-sm-5">
							<input type="text" name="table" value="" id="input-table" class="form-control" />
							<?php echo form_error('table', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div id="table-box" class="col-sm-5">
							<div class="table-responsive panel-selected">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Name</th>
											<th>Minimum</th>
											<th>Capacity</th>
											<th>Remove</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($tables as $table) { ?>
										<?php if (in_array($table['table_id'], $location_tables)) {?>
										<tr id="table-box<?php echo $table['table_id']; ?>">
											<td><?php echo $table['table_name']; ?></td>
											<td><?php echo $table['min_capacity']; ?></td>
											<td><?php echo $table['max_capacity']; ?></td>
											<td class="img"><a class="btn btn-danger btn-xs" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a><input type="hidden" name="tables[]" value="<?php echo $table['table_id']; ?>" /></td>
										</tr>
										<?php } ?>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-interval" class="col-sm-2 control-label">Time Interval:
							<span class="help-block">Set in minutes the time between each reservation</span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="reservation_interval" id="input-reserve-interval" class="form-control" value="<?php echo set_value('reservation_interval', $reservation_interval); ?>" />
								<span class="input-group-addon">minutes</span>
							</div>
							<?php echo form_error('reservation_interval', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-turn" class="col-sm-2 control-label">Turn Time:
							<span class="help-block">Set in minutes the turn time for each reservation</span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="reservation_turn" id="input-reserve-turn" class="form-control" value="<?php echo set_value('reservation_turn', $reservation_turn); ?>" />
								<span class="input-group-addon">minutes</span>
							</div>
							<?php echo form_error('reservation_turn', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="delivery" class="tab-pane row wrap-none">
					<?php if ($has_lat_lng) { ?>
						<div class="col-md-8 wrap-none">
							<div id="map-holder" style="height:550px;"></div>
						</div>
						<div class="col-md-4 wrap-none">
							<div class="panel panel-default panel-delivery-areas border-left-3">
								<div class="panel-heading"><h3 class="panel-title">Delivery Areas</h3></div>
								<div id="delivery-areas" class="panel-body">
									<?php $panel_row = 1; ?>
									<?php foreach ($delivery_areas as $area) { ?>
										<div id="delivery-area<?php echo $panel_row; ?>" class="panel panel-default">
											<input type="hidden" name="delivery_areas[<?php echo $panel_row; ?>][shape]" value="<?php echo $area['shape']; ?>" />
											<input type="hidden" name="delivery_areas[<?php echo $panel_row; ?>][vertices]" value="<?php echo $area['vertices']; ?>" />
											<input type="hidden" name="delivery_areas[<?php echo $panel_row; ?>][circle]" value="<?php echo $area['circle']; ?>" />
											<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#delivery-areas" href="#delivery-area<?php echo $panel_row; ?> .collapse">
												<div class="area-toggle"><i class="fa fa-angle-double-down up"></i><i class="fa fa-angle-double-up down"></i></div>
												<div class="area-name">&nbsp;&nbsp;Area <?php echo $panel_row; ?></div>
												<?php if ($area['type'] == 'circle') { ?>
													<div class="area-color"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x fa-inverse"></i><i class="fa fa-circle fa-stack-1x" style="color:<?php echo $area['color']; ?>"></i></span></div>
												<?php } else { ?>
													<div class="area-color"><span class="fa-stack"><i class="fa fa-stop fa-stack-2x fa-inverse"></i><i class="fa fa-stop fa-stack-1x" style="color:<?php echo $area['color']; ?>"></i></span></div>
												<?php } ?>
												<div class="area-buttons pull-right hide"><a title="Edit"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp; <a class="btn-times area-remove" title="Remove" onClick="$(this).parent().parent().parent().remove();"><i class="fa fa-times-circle"></i></a></div>
											</div>
											<div class="collapse">
												<div class="panel-body">
													<div class="form-group">
														<div class="btn-group btn-group-toggle area-types wrap-vertical" data-toggle="buttons">
															<?php if ($area['type'] == 'circle') { ?>
																<label class="btn btn-default active area-type-circle" data-btn="btn-success"><input type="radio" name="delivery_areas[<?php echo $panel_row; ?>][type]" value="circle" checked="checked">Circle</label>
																<label class="btn btn-default area-type-shape" data-btn="btn-success"><input type="radio" name="delivery_areas[<?php echo $panel_row; ?>][type]" value="shape">Shape</label>
															<?php } else { ?>
																<label class="btn btn-default area-type-circle" data-btn="btn-success"><input type="radio" name="delivery_areas[<?php echo $panel_row; ?>][type]" value="circle">Circle</label>
																<label class="btn btn-default active area-type-shape" data-btn="btn-success"><input type="radio" name="delivery_areas[<?php echo $panel_row; ?>][type]" value="shape" checked="checked">Shape</label>
															<?php } ?>
														</div>
														<?php echo form_error('delivery_areas['.$panel_row.'][type]', '<span class="text-danger">', '</span>'); ?>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-5 control-label">Name:</label>
														<div class="col-sm-7 wrap-none wrap-right">
															<input type="text" name="delivery_areas[<?php echo $panel_row; ?>][name]" id="" class="form-control" value="<?php echo $area['name']; ?>" />
															<?php echo form_error('delivery_areas['.$panel_row.'][name]', '<span class="text-danger">', '</span>'); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-5 control-label">Delivery charge:</label>
														<div class="col-sm-7 wrap-none wrap-right">
															<div class="input-group">
																<input type="text" name="delivery_areas[<?php echo $panel_row; ?>][charge]" id="" class="form-control" value="<?php echo $area['charge']; ?>" />
																<span class="input-group-addon">.00</span>
															</div>
															<?php echo form_error('delivery_areas['.$panel_row.'][charge]', '<span class="text-danger">', '</span>'); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-5 control-label">Minimum order:</label>
														<div class="col-sm-7 wrap-none wrap-right">
															<div class="input-group">
																<input type="text" name="delivery_areas[<?php echo $panel_row; ?>][min_amount]" id="" class="form-control" value="<?php echo $area['min_amount']; ?>" />
																<span class="input-group-addon">.00</span>
															</div>
															<?php echo form_error('delivery_areas['.$panel_row.'][min_amount]', '<span class="text-danger">', '</span>'); ?>
														</div>
													</div>
												</div>
												<div class="panel-footer hide">
													<div class="clearfix text-center">
														<button type="button" class="btn btn-default pull-left area-cancel" onClick="$('#delivery-area<?php echo $panel_row; ?> .panel-heading').trigger('click');">Close</button>
														<button type="button" class="btn btn-success pull-right area-save">Save</button>
													</div>
												</div>
											</div>
											</div>
										<?php $panel_row++; ?>
									<?php } ?>
								</div>
								<div class="panel-footer">
									<div class="clearfix text-center">
										<button type="button" class="btn btn-default area-new" onClick="addDeliveryArea();"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add new area</button>
									</div>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<p class="alert text-danger">Delivery area map will be visible after location has been saved.</p>
					<?php } ?>
				</div>
			</div>
		</form>
	</div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo root_url("assets/js/datepicker/bootstrap-timepicker.css"); ?>">
<script type="text/javascript" src="<?php echo root_url("assets/js/datepicker/bootstrap-timepicker.js"); ?>"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.timepicker').timepicker({
		defaultTime: '11:45 AM'
	});

	$('input[name="opening_type"]').on('change', function() {
		if (this.value == '24_7') {
			$('#opening-daily').fadeOut();
			$('#opening-flexible').fadeOut();
		}

		if (this.value == 'daily') {
			$('#opening-flexible').fadeOut();
			$('#opening-daily').fadeIn();
		}

		if (this.value == 'flexible') {
			$('#opening-daily').fadeOut();
			$('#opening-flexible').fadeIn();
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'table\']').select2({
	placeholder: 'Start typing...',
	minimumInputLength: 2,
	ajax: {
		url: '<?php echo site_url("/tables/autocomplete"); ?>',
		dataType: 'json',
		quietMillis: 100,
		data: function (term, page) {
			return {
				term: term, //search term
				page_limit: 10 // page size
			};
		},
		results: function (data, page, query) {
			return { results: data.results };
		}
	}
});

$('input[name=\'table\']').on('select2-selecting', function(e) {
	$('#table-box' + e.choice.id).remove();
	$('#table-box table tbody').append('<tr id="table-box' + e.choice.id + '"><td class="name">' + e.choice.text + '</td><td>' + e.choice.min + '</td><td>' + e.choice.max + '</td><td class="img">' + '<a class="btn btn-danger btn-xs" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>' + '<input type="hidden" name="tables[]" value="' + e.choice.id + '" /></td></tr>');
});
//--></script>
<?php if ($has_lat_lng) { ?>
<script type="text/javascript"><!--
$(document).on('change', '.area-types input[type="radio"]', function () {
	var color_icon = $(this).parent().parent().parent().parent().parent().parent().find('.panel-heading .area-color .fa');
	if (this.value == 'shape') {
		color_icon.removeClass('fa-circle').addClass('fa-stop');
	} else {
		color_icon.removeClass('fa-stop').addClass('fa-circle');
	}
});

//--></script>
<script src="http://maps.googleapis.com/maps/api/js?v=3<?php echo $map_key; ?>&sensor=false&region=GB&libraries=geometry"></script>
<script type="text/javascript">//<![CDATA[
var map = null,
panel_row = <?php echo $panel_row; ?>,
colors = <?php echo $area_colors; ?>,
deliveryAreas = [],
centerLatLng = new google.maps.LatLng(
	parseFloat(<?php echo json_encode($location_lat); ?>),
	parseFloat(<?php echo json_encode($location_lng); ?>)
);

jQuery('#open-map').click(function() {
    if (map === null) {
        initializeMap();
    }
});

if (!google.maps.Polygon.prototype.getBounds) {
	google.maps.Polygon.prototype.getBounds = function() {
		var bounds = new google.maps.LatLngBounds();
		var paths = this.getPaths();
		var path;
		for (var i = 0; i < paths.getLength(); i++) {
			path = paths.getAt(i);
			for (var ii = 0; ii < path.getLength(); ii++) {
				bounds.extend(path.getAt(ii));
			}
		}
		return bounds;
	}
}

function initializeMap() {
	var mapOptions = {
		zoom: 14,
		center: centerLatLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(
		document.getElementById('map-holder'), mapOptions);

	var marker = new google.maps.Marker({
		position: centerLatLng,
		map: map
	});

	$('#edit-form').on('submit', saveDeliveryAreas);

	clearMapAreas();
	createSavedArea(panel_row)
}

function defaultAreaOptions() {
	return {
		visible: false,
		draggable: true,
		strokeOpacity: 0.8,
		strokeWeight: 3,
		fillOpacity: 0.15
	};
}

function saveDeliveryAreas() {
	try {
		serializeAreas();
	} catch (ex) {
		console.log(ex);
		alert(ex);
		ex.preventDefault();
		return false;
	}
}

function addMapArea(deliveryArea) {
	deliveryArea.setMap(map);
	deliveryAreas.push(deliveryArea);
	setMapAreaEvents(deliveryArea);
}

function deleteMapArea(deliveryArea) {
	for (var i = deliveryAreas.length -1; i >= 0 ; i--) {
		if (deliveryAreas[i].row == deliveryArea.row) {
			toggleVisibleMapArea(deliveryArea);
			deliveryAreas.splice(i, 1);
		}
	}
}

function clearMapAreas() {
	deliveryAreas.forEach(function(area) {
		area.setMap(null);
		deleteMapArea(area);
	});
}

function toggleMapArea(deliveryArea, type) {
	deliveryAreas.forEach(function(area) {
		area.setOptions({ strokeWeight: 3, zIndex: 2, editable: false });
		if (area.row == deliveryArea.row) {
			if (type != undefined && area.type == type) {
				area.setOptions({ strokeWeight: 6, zIndex: 200, fillOpacity: 0.35, editable: true, visible: true });
			}
		}
	});
}

function toggleMapAreaType(deliveryArea, type) {
	deliveryAreas.forEach(function(area) {
		area.setOptions({ strokeWeight: 3, zIndex: 2, editable: false });
		if (area.row == deliveryArea.row) {
			area.setOptions({ visible: false });
			if (type != undefined && area.type == type) {
				area.setOptions({ strokeWeight: 6, zIndex: 200, fillOpacity: 0.15, editable: true, visible: true });
			}
		}
	});
}

function toggleVisibleMapArea(deliveryArea, type) {
	deliveryAreas.forEach(function(area) {
		if (area.row == deliveryArea.row) {
			area.setOptions({ visible: false });
			if (type != undefined && area.type == type) {
				area.setOptions({ visible: true });
			}
		}
	});
}

function toggleHoverMapArea(deliveryArea, type, event) {
	deliveryAreas.forEach(function(area) {
		if (area.row == deliveryArea.row) {
			area.setOptions({ fillOpacity: 0.15 });
			if (type != undefined && area.type == type && event == 'mouseover') {
				area.setOptions({ fillOpacity: 0.35 });
			}
		}
	});
}

function setMapAreaEvents(deliveryArea) {
	google.maps.event.addDomListener(deliveryArea, 'click', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
		$(deliveryArea.div + ' .panel-heading').trigger('click');
		if (!$(deliveryArea.div + ' .panel-heading').hasClass('collapsed')) {
   			toggleMapArea(deliveryArea, type);
		} else {
	   		toggleMapArea(deliveryArea);
		}
	});

	google.maps.event.addDomListener(deliveryArea, 'mouseover', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
   		toggleHoverMapArea(deliveryArea, type, 'mouseover');
	});

	google.maps.event.addDomListener(deliveryArea, 'mouseout', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
   		toggleHoverMapArea(deliveryArea, type, 'mouseout');
	});
}

function setDeliveryAreaEvents(deliveryArea) {
	google.maps.event.addDomListener($(deliveryArea.div + ' .panel-heading')[0], 'click', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
		if ($(deliveryArea.div + ' .panel-heading').hasClass('collapsed')) {
   			toggleMapArea(deliveryArea, type);
		} else {
	   		toggleMapArea(deliveryArea);
		}
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .area-type-shape')[0], 'click', function(event) {
   		toggleMapAreaType(deliveryArea, 'shape');
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .area-type-circle')[0], 'click', function(event) {
   		toggleMapAreaType(deliveryArea, 'circle');
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .panel-heading .area-remove')[0], 'click', function(event) {
   		deleteMapArea(deliveryArea);
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .panel-heading')[0], 'mouseover', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
   		toggleHoverMapArea(deliveryArea, type, 'mouseover');
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .panel-heading')[0], 'mouseout', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
   		toggleHoverMapArea(deliveryArea, type, 'mouseout');
	});
}

function resizeMap() {
	var allAreasBounds;

	if (!deliveryAreas.length){
		return;
	}

	allAreasBounds = deliveryAreas[0].getBounds();
	deliveryAreas.forEach(function(area) {
		var bounds = area.getBounds();
		allAreasBounds.union(bounds);
	});

	map.fitBounds(allAreasBounds);
}

function drawShapeArea(row, shape) {
	var options, shapeArea,
	color = (colors[row-1] == undefined) ? '#F16745' : colors[row-1];

	options = defaultAreaOptions();
	options.paths = shape;
	options.strokeColor = color;
	options.fillColor = color;
	shapeArea = new google.maps.Polygon(options);
	addMapArea(shapeArea);

    shapeArea.div = '#delivery-area' + row;
    shapeArea.row = row;
    shapeArea.name = 'Area ' + row;
    shapeArea.color = color;
    shapeArea.type = 'shape';

	return shapeArea;
}

function drawCircleArea(row, center, radius) {
	var options, circleArea,
	color = (colors[row-1] == undefined) ? '#F16745' : colors[row-1];

	options = defaultAreaOptions();
	options.strokeColor = color;
	options.fillColor = color;
	options.center = center;
	options.radius = radius;
	circleArea = new google.maps.Circle(options);
	addMapArea(circleArea);

    circleArea.div = '#delivery-area' + row;
    circleArea.row = row;
    circleArea.name = 'Area ' + row;
    circleArea.color = color;
    circleArea.type = 'circle';

	return circleArea;
}

function serializeAreas() {
	deliveryAreas.forEach(function(area) {
		var outputPath = [],
		outputVertices = [],
		outputCircle = [],
		shape, encodedPath;

		if (area.type == 'shape') {
			var vertices = area.getPath();
			shape = google.maps.geometry.encoding.encodePath(vertices);
			encodedPath = shape.replace(/\\/g,',').replace(/\//g,'-');
			outputPath.push({shape: encodedPath});

			for (var i = 0; i < vertices.getLength(); i++) {
				var xy = vertices.getAt(i);
				outputVertices.push({
					lat: xy.lat(),
					lng: xy.lng()
				});
			}

			outputPath = JSON.stringify(outputPath)
			outputVertices = JSON.stringify(outputVertices)
			$('input[name="delivery_areas[' + area.row + '][shape]"]').val(outputPath);
			$('input[name="delivery_areas[' + area.row + '][vertices]"]').val(outputVertices);
		}

		if (area.type == 'circle') {
			outputCircle.push({center: {lat: area.getCenter().lat(), lng: area.getCenter().lng()}});
			outputCircle.push({radius: area.getRadius()});

			outputCircle = JSON.stringify(outputCircle)
			$('input[name="delivery_areas[' + area.row + '][circle]"]').val(outputCircle);
		}
	});
}

function unserializedAreas(row) {
	var savedAreas = [];

	for (i = 1; i < row; i++) {
		var shape = $('input[name="delivery_areas[' + i + '][shape]"]').val();
		var circle = $('input[name="delivery_areas[' + i + '][circle]"]').val();
		var type = $('input[name="delivery_areas[' + i + '][type]"]:checked').val();

		try {
			shape = JSON.parse(shape);
			circle = JSON.parse(circle);
		} catch (e){
			console.log(e);
		}

		savedAreas.push({
			shape: shape[0].shape,
			center: circle[0].center,
			radius: circle[1].radius,
			type: type,
			row: i
		});
	}

	return savedAreas;
}

function createSavedArea(row) {
	var savedAreas = unserializedAreas(row);

	savedAreas.forEach(function(area) {
		var shapeArea, circleArea,
		shape, decodedPath;

		if (area.center != undefined && area.radius != undefined) {
			center = new google.maps.LatLng(area.center.lat, area.center.lng)
			circleArea = drawCircleArea(area.row, center, area.radius);
		}

		if (area.shape != undefined) {
			shape = area.shape.replace(/,/g,'\\').replace(/-/g,'\/');
			decodedPath = google.maps.geometry.encoding.decodePath(shape);

			shapeArea = drawShapeArea(area.row, decodedPath);
		}

		if (area.type == 'circle') {
	   		toggleVisibleMapArea(circleArea, 'circle');
			setDeliveryAreaEvents(circleArea);
		} else {
	   		toggleVisibleMapArea(shapeArea, 'shape');
			setDeliveryAreaEvents(shapeArea);
		}
	});

    resizeMap();
}

function createDeliveryArea(row) {
	var circleArea, shapeArea, radius = 1000 * (row / 2), ne, sw, scale = 0.15, windowWidth, windowHeight,
	widthMargin, heightMargin, top, bottom, left, right;

	circleArea = drawCircleArea(row, centerLatLng, radius);
	ne = circleArea.getBounds().getNorthEast();
	sw = circleArea.getBounds().getSouthWest();
	scale = 0.15;
	windowWidth = ne.lng() - sw.lng();
	windowHeight = ne.lat() - sw.lat();
	widthMargin = windowWidth * scale;
	heightMargin = windowHeight * scale;
	top = ne.lat() - heightMargin;
	bottom = sw.lat() + heightMargin;
	left = sw.lng() + widthMargin;
	right = ne.lng() - widthMargin;
	shape = [
		new google.maps.LatLng(top, right),
		new google.maps.LatLng(bottom, right),
		new google.maps.LatLng(bottom, left),
		new google.maps.LatLng(top, left)
	];

	shapeArea = drawShapeArea(row, shape);
	toggleVisibleMapArea(shapeArea, 'shape');

    resizeMap();
	return shapeArea
}

function addDeliveryArea() {
	deliveryArea = createDeliveryArea(panel_row);

	html  = '<div id="delivery-area' + panel_row + '" class="panel panel-default">';
	html += '	<input type="hidden" name="delivery_areas[' + panel_row + '][shape]" value="" />';
	html += '	<input type="hidden" name="delivery_areas[' + panel_row + '][vertices]" value="" />';
	html += '	<input type="hidden" name="delivery_areas[' + panel_row + '][circle]" value="" />';
	html += '	<div class="panel-heading collapsed" data-toggle="collapse" data-target="#delivery-area' + panel_row + ' .collapse">';
	html += '		<div class="area-toggle"><i class="fa fa-angle-double-down up"></i><i class="fa fa-angle-double-up down"></i></div>';
	html += '		<div class="area-name">&nbsp;&nbsp; Area ' + panel_row + '</div>';
	html += '		<div class="area-color"><span class="fa-stack"><i class="fa fa-stop fa-stack-2x fa-inverse"></i><i class="fa fa-stop fa-stack-1x" style="color:' + deliveryArea.color + ';"></i></span></div>';
	html += '		<div class="area-buttons pull-right hide"><a title="Edit"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp; <a class="btn-times area-remove" title="Remove" onClick="$(this).parent().parent().parent().remove();"><i class="fa fa-times-circle"></i></a></div>';
	html += '	</div>';
	html += '	<div class="collapse">';
	html += '	<div class="panel-body">';
	html += '		<div class="form-group">';
	html += '			<div class="btn-group btn-group-toggle area-types wrap-vertical" data-toggle="buttons">';
	html += '				<label class="btn btn-default area-type-circle" data-btn="btn-success"><input type="radio" name="delivery_areas[' + panel_row + '][type]" value="circle">Circle</label>';
	html += '				<label class="btn btn-default active btn-success area-type-shape" data-btn="btn-success"><input type="radio" name="delivery_areas[' + panel_row + '][type]" value="shape" checked="checked">Shape</label>';
	html += '			</div>';
	html += '		</div>';
	html += '		<div class="form-group">';
	html += '			<label for="" class="col-sm-5 control-label">Name:</label>';
	html += '			<div class="col-sm-7 wrap-none wrap-right">';
	html += '				<input type="text" name="delivery_areas[' + panel_row + '][name]" id="" class="form-control" value="Area ' + panel_row + '" />';
	html += '			</div>';
	html += '		</div>';
	html += '		<div class="form-group">';
	html += '			<label for="" class="col-sm-5 control-label">Delivery charge:</label>';
	html += '			<div class="col-sm-7 wrap-none wrap-right">';
		html += '			<div class="input-group">';
		html += '				<input type="text" name="delivery_areas[' + panel_row + '][charge]" id="" class="form-control" value="" />';
		html += '				<span class="input-group-addon">.00</span>';
		html += '			</div>';
	html += '			</div>';
	html += '		</div>';
	html += '		<div class="form-group">';
	html += '			<label for="" class="col-sm-5 control-label">Minimum order:</label>';
	html += '			<div class="col-sm-7 wrap-none wrap-right">';
		html += '			<div class="input-group">';
		html += '				<input type="text" name="delivery_areas[' + panel_row + '][min_amount]" id="" class="form-control" value="" />';
		html += '				<span class="input-group-addon">.00</span>';
		html += '			</div>';
	html += '			</div>';
	html += '		</div>';
	html += '	</div>';
	html += '	<div class="panel-footer hide">';
	html += '		<div class="clearfix text-center">';
	html += '			<button type="button" class="btn btn-default pull-left area-cancel" onClick="$(\'#delivery-area' + panel_row + ' .panel-heading\').trigger(\'click\');">Close</button>';
	html += '			<button type="button" class="btn btn-success pull-right area-save">Save</button>';
	html += '		</div>';
	html += '	</div>';
	html += '	</div>';
	html += '</div>';

	$('#delivery-areas').append(html);

	panel_row++;
	setDeliveryAreaEvents(deliveryArea);
}
//]]></script>
<?php } ?>
<?php echo $footer; ?>