<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h3><?php echo $text_summary; ?></h3>
					<span class="under-heading"></span>
				</div>
			</div>
		</div>

		<div class="row">
			<?php echo $content_left; ?><?php echo $content_right; ?>
			<?php
				if (!empty($content_left) AND !empty($content_right)) {
					$class = "col-sm-6 col-md-6";
				} else if (!empty($content_left) OR !empty($content_right)) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="<?php echo $class; ?>">
				<div class="row text-center" style="display:<?php echo (!$main_local) ? 'block': 'none';?>">
					<div class="col-md-12">
						<form method="POST" action="<?php echo $local_action; ?>">
							<div class="form-group">
								<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
								<div class="col-sm-4 center-block">
									<div class="input-group postcode-group">
										<input type="text" id="postcode" class="form-control text-center postcode-control" name="postcode" value="<?php echo $postcode; ?>">
										<a id="search" class="input-group-addon btn btn-success" onclick="$('form').submit();"><?php echo $text_find; ?></a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<?php if ($main_local) { ?>
					<div class="search-content row" style="display: block;">
						<div id="contactForm" class="col-md-7">
							<form accept-charset="utf-8" method="POST" action="<?php echo $action; ?>" role="form">
								<div class="row">
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<select name="subject" id="subject" class="form-control">
												<option value="">select a subject</option>
												<?php foreach($subjects as $subject_id => $subject) { ?>
													<option value="<?php echo $subject_id; ?>"><?php echo $subject; ?></option>
												<?php } ?>
											</select>
											<?php echo form_error('subject', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group">
											<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="<?php echo $entry_email; ?>" />
											<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<input type="text" name="full_name" id="full-name" class="form-control" value="<?php echo set_value('full_name'); ?>" placeholder="<?php echo $entry_full_name; ?>" />
											<?php echo form_error('full_name', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group">
											<input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo set_value('telephone'); ?>" placeholder="<?php echo $entry_telephone; ?>" />
											<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<textarea name="comment" id="comment" class="form-control" rows="5" placeholder="<?php echo $entry_comment; ?>"><?php echo set_value('comment'); ?></textarea>
									<?php echo form_error('comment', '<span class="text-danger">', '</span>'); ?>
								</div>
								<div class="form-group">
									<div class="input-group">
					 				<span><?php echo $captcha_image; ?></span>
										<input type="text" name="captcha" class="form-control" placeholder="<?php echo $entry_captcha; ?>" />
									</div>
									<?php echo form_error('captcha', '<span class="text-danger">', '</span>'); ?>
								</div>
								<br />

								<div class="row">
									<div class="col-sm-6 col-md-6">
										<div class="buttons">
											<button type="submit" class="btn btn-success btn-block"><?php echo $button_send; ?></button>
										</div>
									</div>
								</div>
							</form>
						</div>

						<div id="selectedLocation" class="col-md-5 border-left">
							<div class="contact-info">
								<h4 class="contact-title"><?php echo $text_local; ?></h4>
								<ul>
									<li><strong><?php echo $location_name; ?></strong></li>
									<li><i class="fa fa-globe"></i><?php echo $location_address; ?></li>
									<li><i class="fa fa-phone"></i><?php echo $location_telephone; ?></li>
								</ul>

								<p>
									<span><?php echo $text_open_or_close; ?></span><br />
									<span><?php echo $text_reviews; ?></span>
								</p>

								<?php if ($opening_hours) { ?>
								<br /><strong><?php echo $text_opening_hours; ?></strong>
								<dl class="dl-horizontal opening-hour">
									<?php foreach ($opening_hours as $opening_hour) { ?>
										<dt><?php echo $opening_hour['day']; ?>:</dt>
										<?php if ($opening_hour['open'] === '00:00' OR $opening_hour['close'] === '00:00') { ?>
											<dd><?php echo $text_open; ?><dd>
										<?php } else { ?>
											<dd><?php echo $opening_hour['open']; ?> - <?php echo $opening_hour['close']; ?></dd>
										<?php } ?>
									<?php } ?>
								</dl>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="heading-section">
								<h3><?php echo $text_find_us; ?></h3>
								<span class="under-heading"></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div id="map" class="">
								<div id="map-holder" style="height:370px;text-align:left;"></div>
							</div>
						</div>
					</div>

					<script src="http://maps.googleapis.com/maps/api/js?v=3<?php echo $map_key; ?>&sensor=false&region=GB"></script>
					<script type="text/javascript">//<![CDATA[
						var map;
						var geocoder = null;
						var bounds = null;
						var markers = [];
						var infoWindow = null;
						var local_name = "<?php echo $location_name; ?>";
						var latlng = new google.maps.LatLng(
										parseFloat("<?php echo $location_lat; ?>"),
										parseFloat("<?php echo $location_lng; ?>")
									);

						function initializeMap() {
							var html = "<b>" + local_name + "</b> <br/>" +
										"<?php echo $location_address; ?><br/>" +
										"<?php echo $location_telephone; ?>";

							var mapOptions = {
                                scrollwheel: false,
                                center: latlng,
								zoom: 14,
								mapTypeId: google.maps.MapTypeId.ROADMAP
							}

							var map = new google.maps.Map(document.getElementById('map-holder'), mapOptions);

							var infowindow = new google.maps.InfoWindow({
								content: html
							});

							var marker = new google.maps.Marker({
											position: latlng,
											map: map,
											title: local_name
										});

							google.maps.event.addListener(marker, 'click', function() {
							  	infowindow.open(map,marker);
							});
						}

					    google.maps.event.addDomListener(window, 'load', initializeMap);
					//]]></script>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>