<div class="content">
	<div class="img_inner home-fixed">
		<div id="search-location">
			<form id="location-form" method="POST" action="<?php echo site_url('main/local_module/distance'); ?>">
				<label for="postcode"><b><?php echo $text_postcode; ?></b></label><br />
				<input type="text" id="postcodeInput" name="postcode" size="20" value="<?php echo $postcode; ?>">
				<input type="button" id="search" onclick="$('#location-form').submit();"value="<?php echo $text_find; ?>"/>
			</form>
		</div>
	</div>

	<?php if ($local_location) { ?>
	<div class="search-content" style="display: block;">
	<div id="map" class="right"><div class="img_inner"><div id="map-holder" style="height:370px;"></div></div></div>   	
	<div id="selectedLocation" class="left">
		<div class="img_inner">
			<div class="container_24">
				<h2><?php echo $text_local; ?></h2>	
				<div class="buttons"><a class="button" href="<?php echo site_url("menus"); ?>"><?php echo $button_view_menu; ?></a></div>
				<dl id="restaurant-info">
					<dt>
						<h3><address><?php echo $location_name; ?> - <?php echo $location_address_1; ?>, <?php echo $location_city; ?>, <?php echo $location_postcode; ?><br/><?php echo $location_telephone; ?></address></h3>
					</dt>
					<dd><?php echo $text_open_or_close; ?></dd>
					<dd><?php echo $text_delivery; ?></dd>
					<dd><?php echo $text_collection; ?></dd>
					<dd class="distance"><span><?php echo $text_distance; ?>:</span> <?php echo $distance; ?></dd>		
					<dd class="charges"><span><?php echo $text_delivery_charge; ?>:</span> <?php echo $delivery_charge; ?></dd>
					<dd class="review"><span><?php echo $text_reviews; ?>:</span> <?php echo $reviews; ?></dd>
				</dl>
		
				<?php if ($opening_hours) { ?>
				<dl class="opening-hour">
					<dt><?php echo $text_opening_hours; ?>:</dt>
					<?php foreach ($opening_hours as $opening_hour) { ?>
						<dd><span><?php echo $opening_hour['day']; ?>:</span>
						<?php if ($opening_hour['open'] === '00:00' OR $opening_hour['close'] === '00:00') { ?>
							<?php echo $text_open; ?>
						<?php } else { ?>
							<?php echo $opening_hour['open']; ?> - <?php echo $opening_hour['close']; ?>
						<?php } ?>
						</dd>
					<?php } ?>
				</dl>
				<?php } ?>
			</div>
		</div>
	</div>
	</div>
	<?php } ?>
</div>
<?php if ($local_location) { ?>
<script src="http://maps.googleapis.com/maps/api/js?v=3<?php echo $map_key; ?>&sensor=false&region=GB"></script>
<script type="text/javascript">//<![CDATA[
	var map;
	var geocoder = null;
	var bounds = null;
	var markers = [];
	var infoWindow = null;
	var json = <?php echo json_encode($local_location); ?>;
	var latlng = new google.maps.LatLng(
					parseFloat(json['location_lat']),
					parseFloat(json['location_lng'])
				); 
	
	function initializeMap() {
		var html = "<b>" + json['location_name'] + "</b> <br/>" + 
					json['location_address_1'] + "<br/>" + json['location_city'] + ", " + json['location_postcode'] + "<br/>" + 
					json['location_telephone'] + "<br /><br /><b>Distance: </b>" + " <?php echo $distance; ?>";

		var mapOptions = {
			center: latlng,
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
				
		var map = new google.maps.Map(document.getElementById('map-holder'), mapOptions);

		var infowindow = new google.maps.InfoWindow({
			content: html
		});

		var marker = new google.maps.Marker({
						position: latlng,
						map: map,
						title: json['location_name']
					});
		
		google.maps.event.addListener(marker, 'click', function() {
		  	infowindow.open(map,marker);
		});
	}

    google.maps.event.addDomListener(window, 'load', initializeMap);
//]]></script>
<?php } ?>