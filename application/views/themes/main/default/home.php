<div class="content">
	<div class="img_inner home-fixed">
		<div id="local-alert"><?php echo $local_alert; ?></div>
		<div id="search-location">
			<form id="location-form" method="POST" action="<?php echo $local_action; ?>">
				<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
				<input type="text" id="postcodeInput" name="postcode" size="20" value="<?php echo $postcode; ?>">
				<input type="button" id="search" onclick="$('#location-form').submit();"value="<?php echo $text_find; ?>"/>
			</form>
		</div>
	</div>
</div>
<?php if ($local_location) { ?>
<script src="http://maps.googleapis.com/maps/api/js?v=3&key=<?php echo $map_key; ?>&sensor=false&region=GB"></script>
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
				
		//var map = new google.maps.Map(document.getElementById('map-holder'), mapOptions);

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

    //google.maps.event.addDomListener(window, 'load', initializeMap);
//]]></script>
<?php } ?>