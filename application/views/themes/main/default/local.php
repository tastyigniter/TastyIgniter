<div class="content">
	<?php if ($local_location) { ?>
	<div class="search-content" style="display: block;">
		<div id="map" class="right"><div class="img_inner"><div id="map-holder" style="height:370px;text-align:left;"></div></div></div>   	
		<div id="selectedLocation" class="left">
			<div class="img_inner">
			<div class="container_24">
				<h2><?php echo $text_local; ?></h2>	
				<div class="buttons"><a class="button" href="<?php echo $menus_url; ?>"><?php echo $button_view_menu; ?></a></div>
				<dl id="restaurant-info">
					<dt>
						<h3><address><?php echo $location_name; ?> - <?php echo $location_address_1; ?>, <?php echo $location_city; ?>, <?php echo $location_postcode; ?><br/><?php echo $location_telephone; ?></address></h3>
					</dt>
					<dd><?php echo $text_open_or_close; ?></dd>
					<dd><?php echo $text_delivery; ?></dd>
					<dd><?php echo $text_collection; ?></dd>
					<dd class="distance"><span><?php echo $text_distance; ?>:</span> <?php echo $distance; ?></dd>		
					<dd class="charges"><span><?php echo $text_delivery_charge; ?>:</span> <?php echo $delivery_charge; ?></dd>
					<dd class="review"><span><?php echo $text_reviews; ?>:</span> <?php echo $text_total_review; ?></dd>
				</dl>
		

				<?php if ($opening_hours) { ?>
				<dl class="opening-hour">
					<dt><?php echo $text_opening_hours; ?></dt>
					<?php foreach ($opening_hours as $opening_hour) { ?>
					<dd>
						<span><?php echo $opening_hour['day']; ?>:</span>
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
	var local_name = "<?php echo $location_name; ?>";
	var latlng = new google.maps.LatLng(
					parseFloat("<?php echo $location_lat; ?>"),
					parseFloat("<?php echo $location_lng; ?>")
				); 
	
	function initializeMap() {
		var html = "<b>" + local_name + "</b> <br/>" + 
					"<?php echo $location_address; ?><br/>" + 
					"<?php echo $location_telephone; ?><br /><br /><b>Distance: </b>" + " <?php echo $distance; ?>";

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
						title: local_name
					});
		
		google.maps.event.addListener(marker, 'click', function() {
		  	infowindow.open(map,marker);
		});
	}

    google.maps.event.addDomListener(window, 'load', initializeMap);
//]]></script>
<?php } ?>