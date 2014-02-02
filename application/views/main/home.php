<div class="content">
	<div id="search-location">
	<form id="location-form" method="POST" action="<?php echo site_url('main/local_module/distance'); ?>">
		<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
  		<input type="text" id="postcodeInput" name="postcode" size="20" value="<?php echo $postcode; ?>">
    	<input type="button" id="search" onclick="$('#location-form').submit();"value="<?php echo $text_find; ?>"/>
	</form>
	</div>

	<?php if ($local_location) { ?>
	<div class="search-content" style="display: block;">
	<div id="map" class="right" style="height:350px;"></div>   	
	<div id="selectedLocation" class="left">
		<h2><?php echo $text_local; ?></h2>	
		<div id="restaurant-info">
			<h4><?php echo $location_name; ?></h4>  	
			<address><?php echo $location_address_1; ?>, <?php echo $location_city; ?>, <?php echo $location_postcode; ?></address> 	
			<?php echo $location_telephone; ?><br /><br />
	
			<span class="is-open"><?php echo $text_open_or_close; ?></span><br />
			<span class=""><?php echo $text_delivery; ?></span><br />
			<span class=""><?php echo $text_collection; ?></span><br />
		</div>
		<br />
		
		<div id="restaurant-extras">
		<table width="50%">
			<tr class="distance">
				<td><?php echo $text_distance; ?>:</td>
				<td><?php echo $distance; ?></td>		
			</tr>
			<tr class="charges">
				<td><?php echo $text_delivery_charge; ?>:</td>
				<td><?php echo $delivery_charge; ?></td>
			</tr>
			<tr class="review">
				<td><?php echo $text_reviews; ?>:</td>
				<td><?php echo $reviews; ?></td>
			</tr>
		</table>
		</div>
		<br />
		
		<?php if ($opening_hours) { ?>
		<div class="opening-hour">
		<b><?php echo $text_opening_hours; ?>:</b>
		<table width="50%">
		<?php foreach ($opening_hours as $opening_hour) { ?>
			<tr>
				<td><?php echo $opening_hour['day']; ?>:</td>
				<?php if ($opening_hour['open'] !== '00:00' || $opening_hour['close'] !== '00:00') { ?>
					<td><?php echo $opening_hour['open']; ?> - <?php echo $opening_hour['close']; ?></td>
				<?php } else { ?>
					<td><?php echo $text_close; ?></td>
				<?php } ?>
			</tr>
		<?php } ?>
		</table>
		</div>
		<?php } ?>
	</div>
	</div>
	<div class="buttons">
		<div class="right"><a class="button" href="<?php echo site_url("menus"); ?>"><?php echo $button_view_menu; ?></a></div>
	</div>
	<?php } ?>
</div>
<?php if ($local_location) { ?>
<script src="http://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyAVEN2XUak42rlf-nxgNuGQIO2ItMYRRjU&sensor=false&region=GB"></script>
<script type="text/javascript">
//<![CDATA[
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
				
		var map = new google.maps.Map(document.getElementById('map'), mapOptions);

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
 
	function showStores(latlng) {
		infoWindow.close();
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
		markers.length = 0;
 
  		bounds = new google.maps.LatLngBounds();

		for (var i in json) {
			createMarker(json);
		}

  		map.fitBounds(bounds);
		map.setZoom(13);
	}
 
	function createMarker(latlng) {
    	var html = "<b>" + json['location_name'] + "</b> <br/>" + 
    				json['location_address_1'] + "<br/>" + json['location_city'] + ", " + json['location_city'] + " " + json['location_postcode'] + "<br/>" + 
    				json['location_telephone'] + "<br /><br /><b>Distance: </b>" + 
    				parseFloat(json['distance']).toFixed(1) + " Miles";

		var marker = new google.maps.Marker({
						position: latlng,
						map: map,
					});
	}
//]]>
</script>
<?php } ?>
