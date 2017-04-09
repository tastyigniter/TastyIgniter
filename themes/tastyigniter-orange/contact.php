<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>

<?php if ($this->alert->get('', 'alert')) { ?>
    <div id="notification">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->alert->display('', 'alert'); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div id="heading">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h3><?php echo lang('text_heading'); ?></h3>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="page-content">
	<div class="container top-spacing">

		<div class="row">
			<?php echo get_partial('content_left'); ?><?php echo get_partial('content_right'); ?>
			<?php
				if (partial_exists('content_left') AND partial_exists('content_right')) {
					$class = "col-sm-6 col-md-6";
				} else if (partial_exists('content_left') OR partial_exists('content_right')) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="content-wrap <?php echo $class; ?>">
				<?php if (!empty($default_local)) { ?>
					<div class="row">
                        <div class="col-md-7 center-block bottom-spacing text-center">
                            <div class="contact-info">
                                <h4 class="contact-title"><?php echo lang('text_summary'); ?></h4>
                                <ul>
                                    <li><strong><?php echo $location_name; ?></strong></li>
                                    <li><i class="fa fa-globe"></i><?php echo $location_address; ?></li>
                                    <li><i class="fa fa-phone"></i><?php echo $location_telephone; ?></li>
                                </ul>
                            </div>
                        </div>

                        <div id="contactForm" class="col-md-7 center-block">
							<form accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>" role="form">
								<div class="row">
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<select name="subject" id="subject" class="form-control">
												<option value=""><?php echo lang('text_select_subject'); ?></option>
												<?php foreach($subjects as $subject_id => $subject) { ?>
													<option value="<?php echo $subject_id; ?>"><?php echo $subject; ?></option>
												<?php } ?>
											</select>
											<?php echo form_error('subject', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group">
											<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="<?php echo lang('label_email'); ?>" />
											<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<input type="text" name="full_name" id="full-name" class="form-control" value="<?php echo set_value('full_name'); ?>" placeholder="<?php echo lang('label_full_name'); ?>" />
											<?php echo form_error('full_name', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group">
											<input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo set_value('telephone'); ?>" placeholder="<?php echo lang('label_telephone'); ?>" />
											<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<textarea name="comment" id="comment" class="form-control" rows="5" placeholder="<?php echo lang('label_comment'); ?>"><?php echo set_value('comment'); ?></textarea>
									<?php echo form_error('comment', '<span class="text-danger">', '</span>'); ?>
								</div>
								<div class="form-group">
									<div class="input-group">
					 				<span><?php echo $captcha_image; ?></span>
										<input type="text" name="captcha" class="form-control" placeholder="<?php echo lang('label_captcha'); ?>" />
									</div>
									<?php echo form_error('captcha', '<span class="text-danger">', '</span>'); ?>
								</div>
								<br />

								<div class="row">
									<div class="col-sm-12 col-md-12">
										<div class="buttons">
											<button type="submit" class="btn btn-primary btn-block"><?php echo lang('button_send'); ?></button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="heading-section">
								<h3><?php echo lang('text_find_us'); ?></h3>
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
							};

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
<?php echo get_footer(); ?>