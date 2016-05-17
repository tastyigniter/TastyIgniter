<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#restaurant" data-toggle="tab"><?php echo lang('text_tab_restaurant'); ?></a></li>
				<li><a href="#option" data-toggle="tab"><?php echo lang('text_tab_options'); ?></a></li>
				<li><a href="#order" data-toggle="tab"><?php echo lang('text_tab_order'); ?></a></li>
				<li><a href="#reservation" data-toggle="tab"><?php echo lang('text_tab_reservation'); ?></a></li>
				<li><a href="#image-manager" data-toggle="tab"><?php echo lang('text_tab_media_manager'); ?></a></li>
				<li><a href="#mail" data-toggle="tab"><?php echo lang('text_tab_mail'); ?></a></li>
				<li><a href="#system" data-toggle="tab"><?php echo lang('text_tab_server'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>" enctype="multipart/form-data" />
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-site-name" class="col-sm-3 control-label"><?php echo lang('label_site_name'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="site_name" id="input-site-name" class="form-control" value="<?php echo config_item('site_name'); ?>" />
							<?php echo form_error('site_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-site-email" class="col-sm-3 control-label"><?php echo lang('label_site_email'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="site_email" id="input-site-email" class="form-control" value="<?php echo config_item('site_email'); ?>" autocomplete="off" />
							<?php echo form_error('site_email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_site_logo'); ?></label>
						<div class="col-sm-5">
							<div class="thumbnail imagebox" id="selectImage">
								<div class="preview">
									<img src="<?php echo $site_logo; ?>" class="thumb img-responsive" id="thumb" />
								</div>
								<div class="caption">
									<span class="name text-center"><?php echo $logo_name; ?></span>
									<input type="hidden" name="site_logo" value="<?php echo set_value('site_logo', $logo_val); ?>" id="field" />
									<p>
										<a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;<?php echo lang('text_select'); ?></a>
										<a class="btn btn-danger" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('.name').html('no_photo.png');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;<?php echo lang('text_remove'); ?></a>
									</p>
								</div>
							</div>
							<?php echo form_error('site_logo', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-meta-description" class="col-sm-3 control-label"><?php echo lang('label_meta_description'); ?></label>
						<div class="col-sm-5">
							<textarea name="meta_description" id="input-meta-description" class="form-control" rows="3"><?php echo config_item('meta_description'); ?></textarea>
							<?php echo form_error('meta_description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-meta-keyowrds" class="col-sm-3 control-label"><?php echo lang('label_meta_keyword'); ?></label>
						<div class="col-sm-5">
							<textarea name="meta_keywords" id="input-meta-keyowrds" class="form-control" rows="3"><?php echo config_item('meta_keywords'); ?></textarea>
							<?php echo form_error('meta_keywords', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="restaurant" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-country" class="col-sm-3 control-label"><?php echo lang('label_country'); ?></label>
						<div class="col-sm-5">
							<select name="country_id" id="input-country" class="form-control">
								<?php foreach ($countries as $country) { ?>
									<?php if ($country['country_id'] === config_item('country_id')) { ?>
										<option value="<?php echo $country['country_id']; ?>" <?php echo set_select('country_id', $country['country_id'], TRUE); ?>><?php echo $country['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $country['country_id']; ?>" <?php echo set_select('country_id', $country['country_id']); ?>><?php echo $country['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('country_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-default-location" class="col-sm-3 control-label"><?php echo lang('label_default_location'); ?>
							<span class="help-block"><?php echo lang('help_default_location'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<select name="default_location_id" id="input-default-location" class="form-control">
									<?php if (!empty($locations)) { ?>
										<?php foreach ($locations as $location) { ?>
											<?php if ($location['location_id'] === config_item('default_location_id')) { ?>
												<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('default_location_id', $location['location_id'], TRUE); ?>><?php echo $location['location_name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('default_location_id', $location['location_id']); ?>><?php echo $location['location_name']; ?></option>
											<?php } ?>
										<?php } ?>
									<?php } else { ?>
										<option value=""><?php echo lang('button_add_location'); ?></option>
									<?php } ?>
								</select>
								<span class="input-group-btn">
									<a href="<?php echo site_url('locations/edit'); ?>" class="btn btn-primary"><?php echo lang('button_add_location'); ?></a>
								</span>
							</div>
							<?php echo form_error('default_location_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_maps'); ?></h4>
					<div class="form-group">
						<label for="input-maps-api-key" class="col-sm-3 control-label"><?php echo lang('label_maps_api_key'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="maps_api_key" id="input-maps-api-key" class="form-control" value="<?php echo set_value('maps_api_key', config_item('maps_api_key')); ?>" />
							<?php echo form_error('maps_api_key', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-distance-unit" class="col-sm-3 control-label"><?php echo lang('label_distance_unit'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('distance_unit') === 'km') { ?>
									<label class="btn btn-default"><input type="radio" name="distance_unit" value="mi" <?php echo set_radio('distance_unit', 'mi'); ?>><?php echo lang('text_miles'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="distance_unit" value="km" <?php echo set_radio('distance_unit', 'km', TRUE); ?>><?php echo lang('text_kilometers'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="distance_unit" value="mi" <?php echo set_radio('distance_unit', 'mi', TRUE); ?>><?php echo lang('text_miles'); ?></label>
									<label class="btn btn-default"><input type="radio" name="distance_unit" value="km" <?php echo set_radio('distance_unit', 'km'); ?>><?php echo lang('text_kilometers'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('distance_unit', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_currency'); ?></h4>
					<div class="form-group">
						<label for="input-currency" class="col-sm-3 control-label"><?php echo lang('label_site_currency'); ?></label>
						<div class="col-sm-5">
							<select name="currency_id" id="input-currency" class="form-control">
								<?php foreach ($currencies as $currency) { ?>
									<?php if ($currency['currency_id'] === config_item('currency_id')) { ?>
										<option value="<?php echo $currency['currency_id']; ?>" <?php echo set_select('currency_id', $currency['currency_id'], TRUE); ?>><?php echo $currency['currency_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $currency['currency_id']; ?>" <?php echo set_select('currency_id', $currency['currency_id']); ?>><?php echo $currency['currency_name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('currency_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-auto-update-currency" class="col-sm-3 control-label"><?php echo lang('label_auto_update_rates'); ?>
							<span class="help-block"><?php echo lang('help_auto_update_rates'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('auto_update_currency_rates') === '1') { ?>
									<label class="btn btn-default"><input type="radio" name="auto_update_currency_rates" value="0" <?php echo set_radio('auto_update_currency_rates', '0'); ?>><?php echo lang('text_manual'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="auto_update_currency_rates" value="1" <?php echo set_radio('auto_update_currency_rates', '1', TRUE); ?>><?php echo lang('text_auto'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="auto_update_currency_rates" value="0" <?php echo set_radio('auto_update_currency_rates', '0', TRUE); ?>><?php echo lang('text_manual'); ?></label>
									<label class="btn btn-default"><input type="radio" name="auto_update_currency_rates" value="1" <?php echo set_radio('auto_update_currency_rates', '1'); ?>><?php echo lang('text_auto'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('auto_update_currency_rates', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-accepted-currency" class="col-sm-3 control-label"><?php echo lang('label_accepted_currency'); ?>
							<span class="help-block"><?php echo lang('help_accepted_currency'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="accepted_currencies[]" id="input-accepted-currency" class="form-control" multiple>
								<?php foreach ($currencies as $currency) { ?>
									<?php if (in_array($currency['currency_id'], config_item('accepted_currencies')) OR $currency['currency_status'] === '1') { ?>
										<option value="<?php echo $currency['currency_id']; ?>" <?php echo set_select('currency_id', $currency['currency_id'], TRUE); ?>><?php echo $currency['currency_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $currency['currency_id']; ?>" <?php echo set_select('currency_id', $currency['currency_id']); ?>><?php echo $currency['currency_name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('accepted_currencies[]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_language'); ?></h4>
					<div class="form-group">
						<label for="input-language" class="col-sm-3 control-label"><?php echo lang('label_site_language'); ?></label>
						<div class="col-sm-5">
							<select name="language_id" id="input-language" class="form-control">
								<?php foreach ($languages as $language) { ?>
									<?php if ($language['language_id'] === config_item('language_id') OR $language['idiom'] === config_item('language_id')) { ?>
										<option value="<?php echo $language['idiom']; ?>" <?php echo set_select('language_id', $language['language_id'], TRUE); ?>><?php echo $language['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $language['idiom']; ?>" <?php echo set_select('language_id', $language['language_id']); ?>><?php echo $language['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('language_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-admin-language" class="col-sm-3 control-label"><?php echo lang('label_admin_language'); ?></label>
						<div class="col-sm-5">
							<select name="admin_language_id" id="input-admin-language" class="form-control">
								<?php foreach ($languages as $language) { ?>
									<?php if ($language['idiom'] === config_item('admin_language_id')) { ?>
										<option value="<?php echo $language['idiom']; ?>" <?php echo set_select('admin_language_id', $language['language_id'], TRUE); ?>><?php echo $language['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $language['idiom']; ?>" <?php echo set_select('admin_language_id', $language['language_id']); ?>><?php echo $language['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('admin_language_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-detect-language" class="col-sm-3 control-label"><?php echo lang('label_detect_language'); ?>
							<span class="help-block"><?php echo lang('help_detect_language'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('detect_language') === '1') { ?>
									<label class="btn btn-default"><input type="radio" name="detect_language" value="0" <?php echo set_radio('detect_language', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="detect_language" value="1" <?php echo set_radio('detect_language', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="detect_language" value="0" <?php echo set_radio('detect_language', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-default"><input type="radio" name="detect_language" value="1" <?php echo set_radio('detect_language', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('detect_language', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_date_time'); ?></h4>
					<div class="form-group">
						<label for="input-timezone" class="col-sm-3 control-label"><?php echo lang('label_timezone'); ?>
							<span class="help-block"><?php echo lang('help_timezone'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="timezone" id="" class="form-control">
								<?php foreach ($timezones as $key => $value) { ?>
									<?php if ($key === config_item('timezone')) { ?>
										<option value="<?php echo $key; ?>" <?php echo set_select('timezone', $key, TRUE); ?>><?php echo $value; ?></option>
									<?php } else { ?>
										<option value="<?php echo $key; ?>" <?php echo set_select('timezone', $key); ?>><?php echo $value; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<span class="help-block"><?php echo lang('text_utc_time'); ?>: <?php echo mdate("{$date_format} {$time_format}", time()); ?></span>
							<?php echo form_error('timezone', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-date-format" class="col-sm-3 control-label"><?php echo lang('label_date_format'); ?></label>
						<div class="col-sm-6">
							<div class="btn-group btn-group-toggle btn-group-<?php echo count($date_formats); ?>" data-toggle="buttons">
								<?php foreach ($date_formats as $format) { ?>
									<?php if ($format === $date_format) { ?>
										<label class="btn btn-default active"><input type="radio" name="date_format" value="<?php echo $format; ?>" <?php echo set_radio('date_format', $format, TRUE); ?>><?php echo mdate($format, time()); ?></label>
									<?php } else { ?>
										<label class="btn btn-default"><input type="radio" name="date_format" value="<?php echo $format; ?>" <?php echo set_radio('date_format', $format); ?>><?php echo mdate($format, time()); ?></label>
									<?php } ?>
								<?php }?>
							</div>
							<?php echo form_error('date_format', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-time-format" class="col-sm-3 control-label"><?php echo lang('label_time_format'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-<?php echo count($time_formats); ?>" data-toggle="buttons">
								<?php foreach ($time_formats as $format) { ?>
									<?php if ($format === $time_format) { ?>
										<label class="btn btn-default active"><input type="radio" name="time_format" value="<?php echo $format; ?>" <?php echo set_radio('time_format', $format, TRUE); ?>><?php echo mdate($format, time()); ?></label>
									<?php } else { ?>
										<label class="btn btn-default"><input type="radio" name="time_format" value="<?php echo $format; ?>" <?php echo set_radio('time_format', $format); ?>><?php echo mdate($format, time()); ?></label>
									<?php } ?>
								<?php }?>
							</div>
							<?php echo form_error('time_format', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="option" class="tab-pane row wrap-all">
					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_menus'); ?></h4>
					<div class="form-group">
						<label for="input-page-limit" class="col-sm-3 control-label"><?php echo lang('label_page_limit'); ?>
							<span class="help-block"><?php echo lang('help_page_limit'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="page_limit" class="form-control" value="<?php echo set_value('page_limit', config_item('page_limit')); ?>" />
							<?php echo form_error('page_limit', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-menus-page-limit" class="col-sm-3 control-label"><?php echo lang('label_menu_page_limit'); ?>
							<span class="help-block"><?php echo lang('help_menu_page_limit'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="menus_page_limit" class="form-control" value="<?php echo set_value('menus_page_limit', config_item('menus_page_limit')); ?>" />
							<?php echo form_error('menus_page_limit', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-show-menu-images" class="col-sm-3 control-label"><?php echo lang('label_show_menu_image'); ?>
							<span class="help-block"><?php echo lang('help_show_menu_image'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('show_menu_images') == '1') { ?>
									<label class="btn btn-default"><input type="radio" name="show_menu_images" value="0" <?php echo set_radio('show_menu_images', '0'); ?>><?php echo lang('text_hide'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="show_menu_images" value="1" <?php echo set_radio('show_menu_images', '1', TRUE); ?>><?php echo lang('text_show'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="show_menu_images" value="0" <?php echo set_radio('show_menu_images', '0', TRUE); ?>><?php echo lang('text_hide'); ?></label>
									<label class="btn btn-default"><input type="radio" name="show_menu_images" value="1" <?php echo set_radio('show_menu_images', '1'); ?>><?php echo lang('text_show'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('show_menu_images', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group" id="menu-image-size">
						<label for="input-menu-image-size" class="col-sm-3 control-label"><?php echo lang('label_menu_image'); ?>
							<span class="help-block"><?php echo lang('help_dimension'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="control-group control-group-2">
								<input type="text" name="menu_images_w" class="form-control" value="<?php echo set_value('menu_images_w', config_item('menu_images_w')); ?>" />
								<input type="text" name="menu_images_h" class="form-control" value="<?php echo set_value('menu_images_h', config_item('menu_images_h')); ?>" />
							</div>
							<?php echo form_error('menu_images_w', '<span class="text-danger">', '</span>'); ?>
							<?php echo form_error('menu_images_h', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-special-category" class="col-sm-3 control-label"><?php echo lang('label_special_category'); ?>
							<span class="help-block"><?php echo lang('help_special_category'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="special_category_id" id="input-special-category" class="form-control">
								<?php foreach ($categories as $category) { ?>
									<?php if ($category['category_id'] === config_item('special_category_id')) { ?>
										<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('category_id', $category['category_id'], TRUE); ?>><?php echo $category['category_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('category_id', $category['category_id']); ?>><?php echo $category['category_name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('special_category_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_taxation'); ?></h4>
					<div class="form-group">
						<label for="input-tax-mode" class="col-sm-3 control-label"><?php echo lang('label_tax_mode'); ?>
							<span class="help-block"><?php echo lang('help_tax_mode'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('tax_mode') == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="tax_mode" value="0" <?php echo set_radio('tax_mode', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="tax_mode" value="1" <?php echo set_radio('tax_mode', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="tax_mode" value="0" <?php echo set_radio('tax_mode', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="tax_mode" value="1" <?php echo set_radio('tax_mode', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('tax_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div id="taxes">
						<div class="form-group">
							<label for="input-tax-percentage" class="col-sm-3 control-label"><?php echo lang('label_tax_percentage'); ?>
								<span class="help-block"><?php echo lang('help_tax_percentage'); ?></span>
							</label>
							<div class="col-sm-5">
								<div class="input-group">
									<input type="text" name="tax_percentage" id="input-tax-percentage" class="form-control" value="<?php echo set_value('tax_percentage', config_item('tax_percentage')); ?>" />
									<span class="input-group-addon"><?php echo lang('text_percentage_sign'); ?></span>
								</div>
								<?php echo form_error('tax_percentage', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-tax-menu-price" class="col-sm-3 control-label"><?php echo lang('label_tax_menu_price'); ?>
								<span class="help-block"><?php echo lang('help_tax_menu_price'); ?></span>
							</label>
							<div class="col-sm-5">
								<select name="tax_menu_price" id="input-tax-menu-price" class="form-control">
									<?php if (config_item('tax_menu_price') === '1') { ?>
										<option value="0" <?php echo set_select('tax_menu_price', '0'); ?>><?php echo lang('text_menu_price_include_tax'); ?></option>
										<option value="1" <?php echo set_select('tax_menu_price', '1', TRUE); ?>><?php echo lang('text_apply_tax_on_menu_price'); ?></option>
									<?php } else if (config_item('tax_menu_price') === '0') { ?>
										<option value="0" <?php echo set_select('tax_menu_price', '0', TRUE); ?>><?php echo lang('text_menu_price_include_tax'); ?></option>
										<option value="1" <?php echo set_select('tax_menu_price', '1'); ?>><?php echo lang('text_apply_tax_on_menu_price'); ?></option>
									<?php } else { ?>
										<option value="0" <?php echo set_select('tax_menu_price', '0'); ?>><?php echo lang('text_menu_price_include_tax'); ?></option>
										<option value="1" <?php echo set_select('tax_menu_price', '1'); ?>><?php echo lang('text_apply_tax_on_menu_price'); ?></option>
									<?php } ?>
								</select>
								<?php echo form_error('tax_menu_price', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-tax-delivery-charge" class="col-sm-3 control-label"><?php echo lang('label_tax_delivery_charge'); ?>
								<span class="help-block"><?php echo lang('help_tax_delivery_charge'); ?></span>
							</label>
							<div class="col-sm-5">
								<div class="btn-group btn-group-switch" data-toggle="buttons">
									<?php if (config_item('tax_delivery_charge') == '1') { ?>
										<label class="btn btn-default"><input type="radio" name="tax_delivery_charge" value="0" <?php echo set_radio('tax_delivery_charge', '0'); ?>><?php echo lang('text_no'); ?></label>
										<label class="btn btn-default active"><input type="radio" name="tax_delivery_charge" value="1" <?php echo set_radio('tax_delivery_charge', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
									<?php } else { ?>
										<label class="btn btn-default active"><input type="radio" name="tax_delivery_charge" value="0" <?php echo set_radio('tax_delivery_charge', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
										<label class="btn btn-default"><input type="radio" name="tax_delivery_charge" value="1" <?php echo set_radio('tax_delivery_charge', '1'); ?>><?php echo lang('text_yes'); ?></label>
									<?php } ?>
								</div>
								<?php echo form_error('tax_delivery_charge', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_stock'); ?></h4>
					<div class="form-group">
						<label for="input-stock-checkout" class="col-sm-3 control-label"><?php echo lang('label_stock_checkout'); ?>
							<span class="help-block"><?php echo lang('help_stock_checkout'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('stock_checkout') == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="stock_checkout" value="0" <?php echo set_radio('stock_checkout', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="stock_checkout" value="1" <?php echo set_radio('stock_checkout', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="stock_checkout" value="0" <?php echo set_radio('stock_checkout', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="stock_checkout" value="1" <?php echo set_radio('stock_checkout', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('stock_checkout', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-show-stock-warning" class="col-sm-3 control-label"><?php echo lang('label_show_stock_warning'); ?>
							<span class="help-block"><?php echo lang('help_show_stock_warning'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('show_stock_warning') == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="show_stock_warning" value="0" <?php echo set_radio('show_stock_warning', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="show_stock_warning" value="1" <?php echo set_radio('show_stock_warning', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="show_stock_warning" value="0" <?php echo set_radio('show_stock_warning', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="show_stock_warning" value="1" <?php echo set_radio('show_stock_warning', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('show_stock_warning', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_account'); ?></h4>
					<div class="form-group">
						<label for="input-customer-group" class="col-sm-3 control-label"><?php echo lang('label_customer_group'); ?></label>
						<div class="col-sm-5">
							<select name="customer_group_id" id="input-customer-group" class="form-control">
								<?php foreach ($customer_groups as $customer_group) { ?>
									<?php if ($customer_group['customer_group_id'] === config_item('customer_group_id')) { ?>
										<option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id'], TRUE); ?> ><?php echo $customer_group['group_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id']); ?> ><?php echo $customer_group['group_name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('customer_group_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_reviews'); ?></h4>
					<div class="form-group">
						<label for="input-allow-reviews" class="col-sm-3 control-label"><?php echo lang('label_allow_reviews'); ?>
							<span class="help-block"><?php echo lang('help_allow_reviews'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('allow_reviews') == '1') { ?>
									<label class="btn btn-danger active"><input type="radio" name="allow_reviews" value="1" <?php echo set_radio('allow_reviews', '1', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="allow_reviews" value="0" <?php echo set_radio('allow_reviews', '0'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger"><input type="radio" name="allow_reviews" value="1" <?php echo set_radio('allow_reviews', '1'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="allow_reviews" value="0" <?php echo set_radio('allow_reviews', '0', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('allow_reviews', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-approve-reviews" class="col-sm-3 control-label"><?php echo lang('label_approve_reviews'); ?>
							<span class="help-block"><?php echo lang('help_approve_reviews'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('approve_reviews') == '1') { ?>
									<label class="btn btn-default"><input type="radio" name="approve_reviews" value="0" <?php echo set_radio('approve_reviews', '0'); ?>><?php echo lang('text_auto'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="approve_reviews" value="1" <?php echo set_radio('approve_reviews', '1', TRUE); ?>><?php echo lang('text_manual'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="approve_reviews" value="0" <?php echo set_radio('approve_reviews', '0', TRUE); ?>><?php echo lang('text_auto'); ?></label>
									<label class="btn btn-default"><input type="radio" name="approve_reviews" value="1" <?php echo set_radio('approve_reviews', '1'); ?>><?php echo lang('text_manual'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('approve_reviews', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_terms'); ?></h4>
					<div class="form-group">
						<label for="input-checkout-terms" class="col-sm-3 control-label"><?php echo lang('label_checkout_terms'); ?>
							<span class="help-block"><?php echo lang('help_checkout_terms'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="checkout_terms" id="input-checkout-terms" class="form-control">
								<option value="0"><?php echo lang('text_none'); ?></option>
								<?php foreach ($pages as $page) { ?>
									<?php if ($page['page_id'] == config_item('checkout_terms')) { ?>
										<option value="<?php echo $page['page_id']; ?>" <?php echo set_select('checkout_terms', $page['page_id'], TRUE); ?>><?php echo $page['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $page['page_id']; ?>" <?php echo set_select('checkout_terms', $page['page_id']); ?>><?php echo $page['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('checkout_terms', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-registration-terms" class="col-sm-3 control-label"><?php echo lang('label_registration_terms'); ?>
							<span class="help-block"><?php echo lang('help_registration_terms'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="registration_terms" id="input-registration-terms" class="form-control">
								<option value="0"><?php echo lang('text_none'); ?></option>
								<?php foreach ($pages as $page) { ?>
									<?php if ($page['page_id'] == config_item('registration_terms')) { ?>
										<option value="<?php echo $page['page_id']; ?>" <?php echo set_select('registration_terms', $page['page_id'], TRUE); ?>><?php echo $page['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $page['page_id']; ?>" <?php echo set_select('registration_terms', $page['page_id']); ?>><?php echo $page['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('registration_terms', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="order" class="tab-pane row wrap-all">
					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_invoice'); ?></h4>
					<div class="form-group">
						<label for="input-invoice-prefix" class="col-sm-3 control-label"><?php echo lang('label_invoice_prefix'); ?>
							<span class="help-block"><?php echo lang('help_invoice_prefix'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="invoice_prefix" id="input-invoice-prefix" class="form-control" value="<?php echo set_value('invoice_prefix', config_item('invoice_prefix')); ?>" />
							<?php echo form_error('invoice_prefix', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-invoice-mode" class="col-sm-3 control-label"><?php echo lang('label_auto_invoicing'); ?>
							<span class="help-block"><?php echo lang('help_auto_invoicing'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('auto_invoicing') === '1') { ?>
									<label class="btn btn-default"><input type="radio" name="auto_invoicing" value="0" <?php echo set_radio('auto_invoicing', '0'); ?>><?php echo lang('text_manual'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="auto_invoicing" value="1" <?php echo set_radio('auto_invoicing', '1', TRUE); ?>><?php echo lang('text_auto'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="auto_invoicing" value="0" <?php echo set_radio('auto_invoicing', '0', TRUE); ?>><?php echo lang('text_manual'); ?></label>
									<label class="btn btn-default"><input type="radio" name="auto_invoicing" value="1" <?php echo set_radio('auto_invoicing', '1'); ?>><?php echo lang('text_auto'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('auto_invoicing', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_checkout'); ?></h4>
					<div class="form-group">
						<label for="input-order-status-default" class="col-sm-3 control-label"><?php echo lang('label_default_order_status'); ?>
							<span class="help-block"><?php echo lang('help_default_order_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="default_order_status" id="input-order-status-default" class="form-control">
								<optgroup label="Orders">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'order') { ?>
										<?php if ($status['status_id'] === config_item('default_order_status') OR $status['status_id'] === config_item('new_order_status')) { ?>
											<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('default_order_status', $status['status_id'], TRUE); ?>><?php echo $status['status_name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('default_order_status', $status['status_id']); ?>><?php echo $status['status_name']; ?></option>
										<?php } ?>
									<?php } ?>
									<?php } ?>
								</optgroup>
							</select>
							<?php echo form_error('default_order_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-status-processing" class="col-sm-3 control-label"><?php echo lang('label_processing_order_status'); ?>
							<span class="help-block"><?php echo lang('help_processing_order_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="processing_order_status[]" id="input-order-status-processing" class="form-control" multiple="multiple">
								<optgroup label="Orders">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'order') { ?>
										<?php if (in_array($status['status_id'], (array) config_item('processing_order_status'))) { ?>
											<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('processing_order_status', $status['status_id'], TRUE); ?>><?php echo $status['status_name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('processing_order_status', $status['status_id']); ?>><?php echo $status['status_name']; ?></option>
										<?php } ?>
									<?php } ?>
									<?php } ?>
								</optgroup>
							</select>
							<?php echo form_error('processing_order_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-status-completed" class="col-sm-3 control-label"><?php echo lang('label_completed_order_status'); ?>
							<span class="help-block"><?php echo lang('help_completed_order_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="completed_order_status[]" id="input-order-status-completed" class="form-control" multiple="multiple">
								<optgroup label="Orders">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'order') { ?>
										<?php if (in_array($status['status_id'], (array) config_item('completed_order_status'))) { ?>
											<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('completed_order_status', $status['status_id'], TRUE); ?>><?php echo $status['status_name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('completed_order_status', $status['status_id']); ?>><?php echo $status['status_name']; ?></option>
										<?php } ?>
									<?php } ?>
									<?php } ?>
								</optgroup>
							</select>
							<?php echo form_error('completed_order_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-status-cancel" class="col-sm-3 control-label"><?php echo lang('label_canceled_order_status'); ?>
							<span class="help-block"><?php echo lang('help_canceled_order_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="canceled_order_status" id="input-order-status-cancel" class="form-control">
								<optgroup label="Orders">
									<?php foreach ($statuses as $status) { ?>
									<?php if ($status['status_for'] === 'order') { ?>
										<?php if ($status['status_id'] === config_item('canceled_order_status')) { ?>
											<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('canceled_order_status', $status['status_id'], TRUE); ?>><?php echo $status['status_name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('canceled_order_status', $status['status_id']); ?>><?php echo $status['status_name']; ?></option>
										<?php } ?>
									<?php } ?>
									<?php } ?>
								</optgroup>
							</select>
							<?php echo form_error('canceled_order_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-delivery-time" class="col-sm-3 control-label"><?php echo lang('label_delivery_time'); ?>
							<span class="help-block"><?php echo lang('help_delivery_time'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="delivery_time" id="input-delivery-time" class="form-control" value="<?php echo set_value('delivery_time', config_item('delivery_time')); ?>" />
								<span class="input-group-addon"><?php echo lang('text_minutes'); ?></span>
							</div>
							<?php echo form_error('delivery_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-collection-time" class="col-sm-3 control-label"><?php echo lang('label_collection_time'); ?>
							<span class="help-block"><?php echo lang('help_collection_time'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="collection_time" id="input-collection-time" class="form-control" value="<?php echo set_value('collection_time', config_item('collection_time')); ?>" />
								<span class="input-group-addon"><?php echo lang('text_minutes'); ?></span>
							</div>
							<?php echo form_error('collection_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-guest-order" class="col-sm-3 control-label"><?php echo lang('label_guest_order'); ?>
							<span class="help-block"><?php echo lang('help_guest_order'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('guest_order') == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="guest_order" value="0" <?php echo set_radio('guest_order', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="guest_order" value="1" <?php echo set_radio('guest_order', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="guest_order" value="0" <?php echo set_radio('guest_order', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="guest_order" value="1" <?php echo set_radio('guest_order', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('guest_order', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-location-order" class="col-sm-3 control-label"><?php echo lang('label_location_order'); ?>
							<span class="help-block"><?php echo lang('help_location_order'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('location_order') === '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="location_order" value="0" <?php echo set_radio('location_order', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="location_order" value="1" <?php echo set_radio('location_order', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="location_order" value="0" <?php echo set_radio('location_order', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="location_order" value="1" <?php echo set_radio('location_order', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('location_order', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-future-orders" class="col-sm-3 control-label"><?php echo lang('label_future_order'); ?>
							<span class="help-block"><?php echo lang('help_future_order'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('future_orders') === '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="future_orders" value="0" <?php echo set_radio('future_orders', '0'); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="future_orders" value="1" <?php echo set_radio('future_orders', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="future_orders" value="0" <?php echo set_radio('future_orders', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-success"><input type="radio" name="future_orders" value="1" <?php echo set_radio('future_orders', '1'); ?>><?php echo lang('text_yes'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('future_orders', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="reservation" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-reserve-mode" class="col-sm-3 control-label"><?php echo lang('label_reservation_mode'); ?>
							<span class="help-block"><?php echo lang('help_reservation_mode'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('reservation_mode') === '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="reservation_mode" value="0" <?php echo set_radio('reservation_mode', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="reservation_mode" value="1" <?php echo set_radio('reservation_mode', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="reservation_mode" value="0" <?php echo set_radio('reservation_mode', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="reservation_mode" value="1" <?php echo set_radio('reservation_mode', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('reservation_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-default-reserve-status" class="col-sm-3 control-label"><?php echo lang('label_default_reservation_status'); ?>
							<span class="help-block"><?php echo lang('help_default_reservation_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="default_reservation_status" id="input-default-reserve-status" class="form-control">
								<optgroup label="Reservations">
									<?php foreach ($statuses as $status) { ?>
                                        <?php if ($status['status_for'] === 'reserve') { ?>
                                            <?php if ($status['status_id'] === config_item('default_reservation_status') OR $status['status_id'] === config_item('new_reservation_status')) { ?>
                                                <option value="<?php echo $status['status_id']; ?>" <?php echo set_select('default_reservation_status', $status['status_id'], TRUE); ?>><?php echo $status['status_name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $status['status_id']; ?>" <?php echo set_select('default_reservation_status', $status['status_id']); ?>><?php echo $status['status_name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
									<?php } ?>
								</optgroup>
							</select>
							<?php echo form_error('default_reservation_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-confirmed-reserve-status" class="col-sm-3 control-label"><?php echo lang('label_confirmed_reservation_status'); ?>
							<span class="help-block"><?php echo lang('help_confirmed_reservation_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="confirmed_reservation_status" id="input-confirmed-reserve-status" class="form-control">
								<optgroup label="Reservations">
									<?php foreach ($statuses as $status) { ?>
                                        <?php if ($status['status_for'] === 'reserve') { ?>
                                            <?php if ($status['status_id'] === config_item('confirmed_reservation_status')) { ?>
                                                <option value="<?php echo $status['status_id']; ?>" <?php echo set_select('confirmed_reservation_status', $status['status_id'], TRUE); ?>><?php echo $status['status_name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $status['status_id']; ?>" <?php echo set_select('confirmed_reservation_status', $status['status_id']); ?>><?php echo $status['status_name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
									<?php } ?>
								</optgroup>
							</select>
							<?php echo form_error('confirmed_reservation_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-canceled-reserve-status" class="col-sm-3 control-label"><?php echo lang('label_canceled_reservation_status'); ?>
							<span class="help-block"><?php echo lang('help_canceled_reservation_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="canceled_reservation_status" id="input-canceled-reserve-status" class="form-control">
								<optgroup label="Reservations">
									<?php foreach ($statuses as $status) { ?>
                                        <?php if ($status['status_for'] === 'reserve') { ?>
                                            <?php if ($status['status_id'] === config_item('canceled_reservation_status')) { ?>
                                                <option value="<?php echo $status['status_id']; ?>" <?php echo set_select('canceled_reservation_status', $status['status_id'], TRUE); ?>><?php echo $status['status_name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $status['status_id']; ?>" <?php echo set_select('canceled_reservation_status', $status['status_id']); ?>><?php echo $status['status_name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
									<?php } ?>
								</optgroup>
							</select>
							<?php echo form_error('canceled_reservation_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-interval" class="col-sm-3 control-label"><?php echo lang('label_reservation_time_interval'); ?>
							<span class="help-block"><?php echo lang('help_reservation_time_interval'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="reservation_time_interval" id="input-reserve-interval" class="form-control" value="<?php echo set_value('reservation_time_interval', config_item('reservation_time_interval')); ?>" />
								<span class="input-group-addon"><?php echo lang('text_minutes'); ?></span>
							</div>
							<?php echo form_error('reservation_time_interval', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-turn" class="col-sm-3 control-label"><?php echo lang('label_reservation_stay_time'); ?>
							<span class="help-block"><?php echo lang('help_reservation_stay_time'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="reservation_stay_time" id="input-reserve-turn" class="form-control" value="<?php echo set_value('reservation_stay_time', config_item('reservation_stay_time')); ?>" />
								<span class="input-group-addon"><?php echo lang('text_minutes'); ?></span>
							</div>
							<?php echo form_error('reservation_stay_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="image-manager" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_media_max_size'); ?>
							<span class="help-block"><?php echo lang('help_media_max_size'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="image_manager[max_size]" id="input-max-size" class="form-control" value="<?php echo set_value('image_manager[max_size]', $image_manager['max_size']); ?>" size="5" />
							<?php echo form_error('image_manager[max_size]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_media_thumb'); ?>
							<span class="help-block"><?php echo lang('help_dimension'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="control-group control-group-2">
								<input type="text" name="image_manager[thumb_width]" class="form-control" value="<?php echo set_value('image_manager[thumb_width]', $image_manager['thumb_width']); ?>" size="5" />
                                <input type="text" name="image_manager[thumb_height]" class="form-control" value="<?php echo set_value('image_manager[thumb_height]', $image_manager['thumb_height']); ?>" size="5" />
                            </div>
							<?php echo form_error('image_manager[thumb_width]', '<span class="text-danger">', '</span>'); ?>
                            <?php echo form_error('image_manager[thumb_height]', '<span class="text-danger">', '</span>'); ?>
                        </div>
					</div>
					<div class="form-group">
						<label for="input-uploads" class="col-sm-3 control-label"><?php echo lang('label_media_uploads'); ?>
							<span class="help-block"><?php echo lang('help_media_upload'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($image_manager['uploads'] == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="image_manager[uploads]" value="0" <?php echo set_radio('image_manager[uploads]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="image_manager[uploads]" value="1" <?php echo set_radio('image_manager[uploads]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="image_manager[uploads]" value="0" <?php echo set_radio('image_manager[uploads]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="image_manager[uploads]" value="1" <?php echo set_radio('image_manager[uploads]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('image_manager[uploads]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-new-folder" class="col-sm-3 control-label"><?php echo lang('label_media_new_folder'); ?>
							<span class="help-block"><?php echo lang('help_media_new_folder'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($image_manager['new_folder'] == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="image_manager[new_folder]" value="0" <?php echo set_radio('image_manager[new_folder]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="image_manager[new_folder]" value="1" <?php echo set_radio('image_manager[new_folder]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="image_manager[new_folder]" value="0" <?php echo set_radio('image_manager[new_folder]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="image_manager[new_folder]" value="1" <?php echo set_radio('image_manager[new_folder]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('image_manager[new_folder]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-copy" class="col-sm-3 control-label"><?php echo lang('label_media_copy'); ?>
							<span class="help-block"><?php echo lang('help_media_copy'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($image_manager['copy'] == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="image_manager[copy]" value="0" <?php echo set_radio('image_manager[copy]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="image_manager[copy]" value="1" <?php echo set_radio('image_manager[copy]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="image_manager[copy]" value="0" <?php echo set_radio('image_manager[copy]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="image_manager[copy]" value="1" <?php echo set_radio('image_manager[copy]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('image_manager[copy]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-move" class="col-sm-3 control-label"><?php echo lang('label_media_move'); ?>
							<span class="help-block"><?php echo lang('help_media_move'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($image_manager['move'] == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="image_manager[move]" value="0" <?php echo set_radio('image_manager[move]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="image_manager[move]" value="1" <?php echo set_radio('image_manager[move]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="image_manager[move]" value="0" <?php echo set_radio('image_manager[move]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="image_manager[move]" value="1" <?php echo set_radio('image_manager[move]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('image_manager[move]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-rename" class="col-sm-3 control-label"><?php echo lang('label_media_rename'); ?>
							<span class="help-block"><?php echo lang('help_media_rename'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($image_manager['rename'] == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="image_manager[rename]" value="0" <?php echo set_radio('image_manager[rename]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="image_manager[rename]" value="1" <?php echo set_radio('image_manager[rename]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="image_manager[rename]" value="0" <?php echo set_radio('image_manager[rename]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="image_manager[rename]" value="1" <?php echo set_radio('image_manager[rename]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('image_manager[rename]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-delete" class="col-sm-3 control-label"><?php echo lang('label_media_delete'); ?>
							<span class="help-block"><?php echo lang('help_media_delete'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($image_manager['delete'] == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="image_manager[delete]" value="0" <?php echo set_radio('image_manager[delete]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="image_manager[delete]" value="1" <?php echo set_radio('image_manager[delete]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="image_manager[delete]" value="0" <?php echo set_radio('image_manager[delete]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="image_manager[delete]" value="1" <?php echo set_radio('image_manager[delete]]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('image_manager[delete]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-transliteration" class="col-sm-3 control-label"><?php echo lang('label_media_transliteration'); ?>
							<span class="help-block"><?php echo lang('help_media_transliteration'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($image_manager['transliteration'] == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="image_manager[transliteration]" value="0" <?php echo set_radio('image_manager[transliteration]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="image_manager[transliteration]" value="1" <?php echo set_radio('image_manager[transliteration]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="image_manager[transliteration]" value="0" <?php echo set_radio('image_manager[transliteration]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="image_manager[transliteration]" value="1" <?php echo set_radio('image_manager[transliteration]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('image_manager[transliteration]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-remember-days" class="col-sm-3 control-label"><?php echo lang('label_media_remember_days'); ?>
							<span class="help-block"><?php echo lang('help_media_remember_days'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="image_manager[remember_days]" id="input-remember-days" class="form-control">
								<?php if ($image_manager['remember_days'] === '1') { ?>
									<option value="1" selected="selected"><?php echo lang('text_24_hour'); ?></option>
									<option value="3"><?php echo lang('text_3_days'); ?></option>
									<option value="5"><?php echo lang('text_5_days'); ?></option>
									<option value="7"><?php echo lang('text_1_week'); ?></option>
								<?php } else if ($image_manager['remember_days'] === '3') { ?>
									<option value="1"><?php echo lang('text_24_hour'); ?></option>
									<option value="3" selected="selected"><?php echo lang('text_3_days'); ?></option>
									<option value="5"><?php echo lang('text_5_days'); ?></option>
									<option value="7"><?php echo lang('text_1_week'); ?></option>
								<?php } else if ($image_manager['remember_days'] === '5') { ?>
									<option value="1"><?php echo lang('text_24_hour'); ?></option>
									<option value="3"><?php echo lang('text_3_days'); ?></option>
									<option value="5" selected="selected"><?php echo lang('text_5_days'); ?></option>
									<option value="7"><?php echo lang('text_1_week'); ?></option>
								<?php } else if ($image_manager['remember_days'] === '7') { ?>
									<option value="1"><?php echo lang('text_24_hour'); ?></option>
									<option value="3"><?php echo lang('text_3_days'); ?></option>
									<option value="5"><?php echo lang('text_5_days'); ?></option>
									<option value="7" selected="selected"><?php echo lang('text_1_week'); ?></option>
								<?php } else { ?>
									<option value="1"><?php echo lang('text_24_hour'); ?></option>
									<option value="3"><?php echo lang('text_3_days'); ?></option>
									<option value="5"><?php echo lang('text_5_days'); ?></option>
									<option value="7" selected="selected"><?php echo lang('text_1_week'); ?></option>
								<?php } ?>
							</select>
							<?php echo form_error('image_manager[remember_days]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-delete-thumbs" class="col-sm-3 control-label"><?php echo lang('label_thumbs'); ?>
							<span class="help-block"><?php echo lang('help_delete_thumbs'); ?></span>
						</label>
						<div class="col-sm-5">
							<a id="input-delete-thumbs" class="btn btn-danger"><?php echo lang('text_delete_thumbs'); ?></a>
						</div>
					</div>
				</div>

				<div id="mail" class="tab-pane row wrap-all">
                    <div class="form-group">
                        <label for="input-registration-email" class="col-sm-3 control-label"><?php echo lang('label_registration_email'); ?>
                            <span class="help-block"><?php echo lang('help_registration_email'); ?></span>
                        </label>
                        <div class="col-sm-5">
	                        <div class="btn-group btn-group-toggle btn-group-2" data-toggle="buttons">
		                        <?php if (config_item('registration_email') == '1' OR in_array('customer', (array) config_item('registration_email'))) { ?>
			                        <label class="btn btn-default active"><input type="checkbox" name="registration_email[]" value="customer" <?php echo set_radio('registration_email[]', 'customer', TRUE); ?>><?php echo lang('text_to_customer'); ?></label>
		                        <?php } else { ?>
			                        <label class="btn btn-default"><input type="checkbox" name="registration_email[]" value="customer" <?php echo set_radio('registration_email[]', 'customer'); ?>><?php echo lang('text_to_customer'); ?></label>
		                        <?php } ?>
		                        <?php if (in_array('admin', (array) config_item('registration_email'))) { ?>
			                        <label class="btn btn-default active"><input type="checkbox" name="registration_email[]" value="admin" <?php echo set_radio('registration_email[]', 'admin', TRUE); ?>><?php echo lang('text_to_admin'); ?></label>
		                        <?php } else { ?>
			                        <label class="btn btn-default"><input type="checkbox" name="registration_email[]" value="admin" <?php echo set_radio('registration_email[]', 'admin'); ?>><?php echo lang('text_to_admin'); ?></label>
		                        <?php } ?>
	                        </div>
                            <?php echo form_error('registration_email[]', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-order-email" class="col-sm-3 control-label"><?php echo lang('label_order_email'); ?>
                            <span class="help-block"><?php echo lang('help_order_email'); ?></span>
                        </label>
                        <div class="col-sm-5">
	                        <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
		                        <?php if (config_item('customer_order_email') == '1' OR in_array('customer', (array) config_item('order_email'))) { ?>
			                        <label class="btn btn-default active"><input type="checkbox" name="order_email[]" value="customer" <?php echo set_radio('order_email[]', 'customer', TRUE); ?>><?php echo lang('text_to_customer'); ?></label>
		                        <?php } else { ?>
			                        <label class="btn btn-default"><input type="checkbox" name="order_email[]" value="customer" <?php echo set_radio('order_email[]', 'customer'); ?>><?php echo lang('text_to_customer'); ?></label>
		                        <?php } ?>
		                        <?php if (in_array('admin', (array) config_item('order_email'))) { ?>
			                        <label class="btn btn-default active"><input type="checkbox" name="order_email[]" value="admin" <?php echo set_radio('order_email[]', 'admin', TRUE); ?>><?php echo lang('text_to_admin'); ?></label>
		                        <?php } else { ?>
			                        <label class="btn btn-default"><input type="checkbox" name="order_email[]" value="admin" <?php echo set_radio('order_email[]', 'admin'); ?>><?php echo lang('text_to_admin'); ?></label>
		                        <?php } ?>
		                        <?php if (config_item('location_order_email') == '1' OR in_array('location', (array) config_item('order_email'))) { ?>
			                        <label class="btn btn-default active"><input type="checkbox" name="order_email[]" value="location" <?php echo set_radio('order_email[]', 'location', TRUE); ?>><?php echo lang('text_to_location'); ?></label>
		                        <?php } else { ?>
			                        <label class="btn btn-default"><input type="checkbox" name="order_email[]" value="location" <?php echo set_radio('order_email[]', 'location'); ?>><?php echo lang('text_to_location'); ?></label>
		                        <?php } ?>
	                        </div>
                            <?php echo form_error('order_email[]', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-reservation-email" class="col-sm-3 control-label"><?php echo lang('label_reservation_email'); ?>
                            <span class="help-block"><?php echo lang('help_reservation_email'); ?></span>
                        </label>
                        <div class="col-sm-5">
	                        <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
		                        <?php if (config_item('customer_reserve_email') == '1' OR in_array('customer', (array) config_item('reservation_email'))) { ?>
			                        <label class="btn btn-default active"><input type="checkbox" name="reservation_email[]" value="customer" <?php echo set_radio('reservation_email[]', 'customer', TRUE); ?>><?php echo lang('text_to_customer'); ?></label>
		                        <?php } else { ?>
			                        <label class="btn btn-default"><input type="checkbox" name="reservation_email[]" value="customer" <?php echo set_radio('reservation_email[]', 'customer'); ?>><?php echo lang('text_to_customer'); ?></label>
		                        <?php } ?>
		                        <?php if (in_array('admin', (array) config_item('reservation_email'))) { ?>
			                        <label class="btn btn-default active"><input type="checkbox" name="reservation_email[]" value="admin" <?php echo set_radio('reservation_email[]', 'admin', TRUE); ?>><?php echo lang('text_to_admin'); ?></label>
		                        <?php } else { ?>
			                        <label class="btn btn-default"><input type="checkbox" name="reservation_email[]" value="admin" <?php echo set_radio('reservation_email[]', 'admin'); ?>><?php echo lang('text_to_admin'); ?></label>
		                        <?php } ?>
		                        <?php if (config_item('location_reserve_email') == '1' OR in_array('location', (array) config_item('reservation_email'))) { ?>
			                        <label class="btn btn-default active"><input type="checkbox" name="reservation_email[]" value="location" <?php echo set_radio('reservation_email[]', 'location', TRUE); ?>><?php echo lang('text_to_location'); ?></label>
		                        <?php } else { ?>
			                        <label class="btn btn-default"><input type="checkbox" name="reservation_email[]" value="location" <?php echo set_radio('reservation_email[]', 'location'); ?>><?php echo lang('text_to_location'); ?></label>
		                        <?php } ?>
	                        </div>
                            <?php echo form_error('customer_reserve_email[]', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
					<div class="form-group">
						<label for="input-protocol" class="col-sm-3 control-label"><?php echo lang('label_protocol'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
								<?php if (config_item('protocol') == 'mail') { ?>
									<label class="btn btn-default active"><input type="radio" name="protocol" value="mail" <?php echo set_radio('protocol', 'mail', TRUE); ?>><?php echo lang('text_mail'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="radio" name="protocol" value="mail" <?php echo set_radio('protocol', 'mail'); ?>><?php echo lang('text_mail'); ?></label>
								<?php } ?>
								<?php if (config_item('protocol') == 'sendmail') { ?>
									<label class="btn btn-default active"><input type="radio" name="protocol" value="sendmail" <?php echo set_radio('protocol', 'sendmail', TRUE); ?>><?php echo lang('text_sendmail'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="radio" name="protocol" value="sendmail" <?php echo set_radio('protocol', 'sendmail'); ?>><?php echo lang('text_sendmail'); ?></label>
								<?php } ?>
								<?php if (config_item('protocol') == 'smtp') { ?>
									<label class="btn btn-default active"><input type="radio" name="protocol" value="smtp" <?php echo set_radio('protocol', 'smtp', TRUE); ?>><?php echo lang('text_smtp'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="radio" name="protocol" value="smtp" <?php echo set_radio('protocol', 'smtp'); ?>><?php echo lang('text_smtp'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('protocol', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<div id="smtp-settings">
						<div class="form-group">
							<label for="input-smtp-host" class="col-sm-3 control-label"><?php echo lang('label_smtp_host'); ?></label>
							<div class="col-sm-5">
								<input type="text" name="smtp_host" id="input-smtp-host" class="form-control" value="<?php echo set_value('smtp_host', config_item('smtp_host')); ?>" />
								<?php echo form_error('smtp_host', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-smtp-port" class="col-sm-3 control-label"><?php echo lang('label_smtp_port'); ?></label>
							<div class="col-sm-5">
								<input type="text" name="smtp_port" id="input-smtp-port" class="form-control" value="<?php echo set_value('smtp_port', config_item('smtp_port')); ?>" />
								<?php echo form_error('smtp_port', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-smtp-user" class="col-sm-3 control-label"><?php echo lang('label_smtp_user'); ?></label>
							<div class="col-sm-5">
								<input type="text" name="smtp_user" id="input-smtp-user" class="form-control" value="<?php echo set_value('smtp_user', config_item('smtp_user')); ?>" autocomplete="off" />
								<?php echo form_error('smtp_user', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-smtp-pass" class="col-sm-3 control-label"><?php echo lang('label_smtp_pass'); ?></label>
							<div class="col-sm-5">
								<input type="password" name="smtp_pass" id="input-smtp-pass" class="form-control" value="<?php echo set_value('smtp_pass', config_item('smtp_pass')); ?>" autocomplete="off" />
								<?php echo form_error('smtp_pass', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-send-test-email" class="col-sm-3 control-label"><?php echo lang('label_test_email'); ?></label>
						<div class="col-sm-5">
							<a id="input-send-test-email" class="btn btn-primary btn-block"><?php echo lang('text_send_test_email'); ?></a>
						</div>
					</div>
				</div>

				<div id="system" class="tab-pane row wrap-all">
					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_maintenance'); ?></h4>
					<div class="form-group">
						<label for="input-maintenance-mode" class="col-sm-3 control-label"><?php echo lang('label_maintenance_mode'); ?>
							<span class="help-block"><?php echo lang('help_maintenance'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('maintenance_mode') == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="maintenance_mode" value="0" <?php echo set_radio('maintenance_mode', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="maintenance_mode" value="1" <?php echo set_radio('maintenance_mode', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="maintenance_mode" value="0" <?php echo set_radio('maintenance_mode', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="maintenance_mode" value="1" <?php echo set_radio('maintenance_mode', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('maintenance_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-maintenance-message" class="col-sm-3 control-label"><?php echo lang('label_maintenance_message'); ?></label>
						<div class="col-sm-5">
							<textarea name="maintenance_message" id="input-maintenance-message" class="form-control" rows="3"><?php echo set_value('maintenance_message', config_item('maintenance_message')); ?></textarea>
                            <?php echo form_error('custom_code', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_permalink'); ?></h4>
					<div class="form-group">
						<label for="input-permalink" class="col-sm-3 control-label"><?php echo lang('label_permalink'); ?>
                            <span class="help-block"><?php echo lang('help_permalink'); ?></span>
                        </label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('permalink') == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="permalink" value="0" <?php echo set_radio('permalink', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="permalink" value="1" <?php echo set_radio('permalink', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="permalink" value="0" <?php echo set_radio('permalink', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="permalink" value="1" <?php echo set_radio('permalink', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('permalink', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_customer_online'); ?></h4>
					<div class="form-group">
						<label for="input-customer-online-time-out" class="col-sm-3 control-label"><?php echo lang('label_customer_online_time_out'); ?>
							<span class="help-block"><?php echo lang('help_customer_online'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="customer_online_time_out" id="input-customer-online-time-out" class="form-control" value="<?php echo set_value('customer_online_time_out', config_item('customer_online_time_out')); ?>" />
								<span class="input-group-addon"><?php echo lang('text_seconds'); ?></span>
							</div>
							<?php echo form_error('customer_online_time_out', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-customer-online-archive-time-out" class="col-sm-3 control-label"><?php echo lang('label_customer_online_archive_time_out'); ?>
							<span class="help-block"><?php echo lang('help_customer_online_archive'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="customer_online_archive_time_out" id="input-customer-online-archive-time-out" class="form-control">
								<?php if (config_item('customer_online_archive_time_out') === '1') { ?>
									<option value="0"><?php echo lang('text_never_delete'); ?></option>
									<option value="1" selected="selected"><?php echo lang('text_1_month'); ?></option>
									<option value="3"><?php echo lang('text_3_months'); ?></option>
									<option value="6"><?php echo lang('text_6_months'); ?></option>
									<option value="12"><?php echo lang('text_12_months'); ?></option>
								<?php } else if (config_item('customer_online_archive_time_out') === '3') { ?>
									<option value="0"><?php echo lang('text_never_delete'); ?></option>
									<option value="1"><?php echo lang('text_1_month'); ?></option>
									<option value="3" selected="selected"><?php echo lang('text_3_months'); ?></option>
									<option value="6"><?php echo lang('text_6_months'); ?></option>
									<option value="12"><?php echo lang('text_12_months'); ?></option>
								<?php } else if (config_item('customer_online_archive_time_out') === '6') { ?>
									<option value="0"><?php echo lang('text_never_delete'); ?></option>
									<option value="1"><?php echo lang('text_1_month'); ?></option>
									<option value="3"><?php echo lang('text_3_months'); ?></option>
									<option value="6" selected="selected"><?php echo lang('text_6_months'); ?></option>
									<option value="12"><?php echo lang('text_12_months'); ?></option>
								<?php } else if (config_item('customer_online_archive_time_out') === '12') { ?>
									<option value="0"><?php echo lang('text_never_delete'); ?></option>
									<option value="1"><?php echo lang('text_1_month'); ?></option>
									<option value="3"><?php echo lang('text_3_months'); ?></option>
									<option value="6"><?php echo lang('text_6_months'); ?></option>
									<option value="12" selected="selected"><?php echo lang('text_12_months'); ?></option>
								<?php } else { ?>
									<option value="0" selected="selected"><?php echo lang('text_never_delete'); ?></option>
									<option value="1"><?php echo lang('text_1_month'); ?></option>
									<option value="3"><?php echo lang('text_3_months'); ?></option>
									<option value="6"><?php echo lang('text_6_months'); ?></option>
									<option value="12"><?php echo lang('text_12_months'); ?></option>
								<?php } ?>
							</select>
							<?php echo form_error('customer_online_archive_time_out', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_caching'); ?></h4>
					<div class="form-group">
						<label for="input-cache-mode" class="col-sm-3 control-label"><?php echo lang('label_cache_mode'); ?>
							<span class="help-block"><?php echo lang('help_cache_mode'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if (config_item('cache_mode') == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="cache_mode" value="0" <?php echo set_radio('cache_mode', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="cache_mode" value="1" <?php echo set_radio('cache_mode', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="cache_mode" value="0" <?php echo set_radio('cache_mode', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="cache_mode" value="1" <?php echo set_radio('cache_mode', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('cache_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-cache-time" class="col-sm-3 control-label"><?php echo lang('label_cache_time'); ?>
							<span class="help-block"><?php echo lang('help_cache_time'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="cache_time" id="input-cache-time" class="form-control" value="<?php echo set_value('cache_time', config_item('cache_time')); ?>" />
								<span class="input-group-addon"><?php echo lang('text_minutes'); ?></span>
							</div>
							<?php echo form_error('cache_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('input[name="auto_lat_lng"]').on('change', function() {
		$('#lat-lng').fadeIn();

		if (this.value == '1') {
			$('#lat-lng').fadeOut();
		}
	});

	$('input[name="show_menu_images"]').on('change', function() {
		if (this.value == '1') {
			$('#menu-image-size').fadeIn();
		} else {
			$('#menu-image-size').fadeOut();
		}
	});

	$('input[name="show_menu_images"]:checked').trigger('change');

	$('input[name="tax_mode"]').on('change', function() {
		if (this.value == '1') {
			$('#taxes').slideDown();
		} else {
			$('#taxes').slideUp();
		}
	});

	$('input[name="tax_mode"]:checked').trigger('change');

	$('input[name="protocol"]').on('change', function() {
		if (this.value == 'smtp') {
			$('#smtp-settings').fadeIn();
		} else {
			$('#smtp-settings').fadeOut();
		}
	});

	$('input[name="protocol"]:checked').trigger('change');

    $('#input-delete-thumbs').click(function() {
        var obj = $(this);

        $.ajax({
            url: js_site_url('settings/delete_thumbs'),
            type: 'POST',
            data: 'delete_thumbs=1',
            dataType: 'json',
            beforeSend: function() {
                obj.html('Deleting...');
            },
            success: function(json) {
                if (json['error']) {
                    obj.html(json['error']);
                }

                if (json['success']) {
                    obj.html(json['success']);
                    obj.removeClass('btn-danger');
                    obj.addClass('btn-success');
                }
            }
        });
    });

    $('#input-send-test-email').click(function() {
        var obj = $(this);

        $.ajax({
            url: js_site_url('settings/send_test_email'),
            type: 'POST',
            data: 'send_test_email=1',
            dataType: 'json',
            beforeSend: function() {
                obj.html('Sending...');
            },
            success: function(json) {
                if (json['error']) {
                    obj.html(json['error']);
                }

                if (json['success']) {
                    obj.html(json['success']);
                    obj.removeClass('btn-primary');
                    obj.addClass('btn-success');
                }
            }
        });

    });
});
//--></script>
<?php echo get_footer(); ?>