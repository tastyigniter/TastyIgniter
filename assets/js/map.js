	var map;
	var geocoder = null;
	var bounds = null;
	var markers = [];
	var infoWindow = null;
 	
	jQuery('#search').click(function() {
		initializeMap();
		var address = jQuery('#postcodeInput').val();
		searchAddress(address);
	});
	
	jQuery('#postcodeInput').keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
       		$('#search').trigger('click');
		}
	}); 

	function searchAddress(address) {
		geocoder.geocode( { 'address': address}, 
			function(results, status) {
				if (status === google.maps.GeocoderStatus.OK) {
					var latlng = results[0].geometry.location;
					//map.setCenter(latlng);
					searchStores(latlng.lat(), latlng.lng());
				} else {
					alert('Address not found: ' + status);
				}
		});
	}
 
	function searchStores(lat, lng) {
		var url = 'http://localhost/TastyIgniter/distance';
		var parameter = { lat: lat, lng: lng };
		jQuery.ajax({
			url: url,
			data: parameter,
			dataType: 'json',
			success: function(json) {
				jQuery('.error, .search-content h2').remove();
		
				if (json['status'] == 'OK') {
					jQuery('.search-content').fadeIn('slow');
					jQuery('.search-content').prepend('<h2>Your local restaurant</h2>');
					showStores(json, status);
					//map.setCenter(latlng);
				}

				if (json['status'] == 'ZERO_RESULTS') {
					jQuery('#notification').html('<p class="error" style="display: none;">Error: Are you sure you\'re in our covered area? <br />Please make sure you entered your postcode correctly.</p>');
					jQuery('.error').fadeIn('slow');
					jQuery('.search-content').hide();
				}
			}
		});
	}
 
	function showStores(json, status) {
		infoWindow.close();
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
		markers.length = 0;
 
  		bounds = new google.maps.LatLngBounds();

		for (var i in json['data']) {
			createMarker(json['data']);
			createDetail(json['data'], json['opening_hours']);
		}

  		map.fitBounds(bounds);
		map.setZoom(15);
	}
 
	function createMarker(store) {
		var latlng = new google.maps.LatLng(
						parseFloat(store['location_lat']),
						parseFloat(store['location_lng'])
					);
    	var html = "<b>" + store['location_name'] + "</b> <br/>" + 
    				store['location_address'] + "<br/>" + store['location_region'] + ", " + store['location_city'] + " " + store['location_postcode'] + "<br/>" + 
    				store['location_phone_number'] + "<br /><br /><b>Distance: </b>" + 
    				parseFloat(store['distance']).toFixed(1) + " Miles";

		var marker = new google.maps.Marker({
						map: map,
						position: latlng
					});
		/*google.maps.event.addListener(marker, 'click', function() {
				infoWindow.setContent(html);
				infoWindow.open(map, marker);
		});*/
		markers.push(marker);
    		
    	bounds.extend(latlng);
	}
	
	function createDetail(store, opening_hours) {
		html = '';
		html += '<div id="restaurant-info">';
		html += '<h4>' + store['location_name'] + '</h4>';
		html += '<address>' + store['location_address'] + ', ' + store['location_region'] + ', ' + store['location_city'] + ' ' + store['location_postcode'] + '</address>';
		html += 'Tel: ' + store['location_phone_number'] + '<br /><br />';
		html += 'Distance: <b>' + parseFloat(store['distance']).toFixed(1) + ' Miles</b>';
		html += '<div class="charges"><b>Delivery Cost:</b> Free</div>';
		html += '<div class="review">User Reviews: (2 reviews)</div>';

		if (opening_hours.length > 0) {
			html += '<div class="opening-hour">';
			html += '<b>Opening Hours:</b>';
			html += '<table>';
			html += '<tr><td>' + opening_hours['0']['day'] + '</td><td>' + opening_hours['0']['time'] + '</td></tr>';
			html += '<tr><td>' + opening_hours['1']['day'] + '</td><td>' + opening_hours['1']['time'] + '</td></tr>';
			html += '<tr><td>' + opening_hours['2']['day'] + '</td><td>' + opening_hours['2']['time'] + '</td></tr>';
			html += '<tr><td>' + opening_hours['3']['day'] + '</td><td>' + opening_hours['3']['time'] + '</td></tr>';
			html += '<tr><td>' + opening_hours['4']['day'] + '</td><td>' + opening_hours['4']['time'] + '</td></tr>';
			html += '<tr><td>' + opening_hours['5']['day'] + '</td><td>' + opening_hours['5']['time'] + '</td></tr>';
			html += '<tr><td>' + opening_hours['6']['day'] + '</td><td>' + opening_hours['6']['time'] + '</td></tr>';
			html += '</table>';
			html += '</div>';
		}

		html += '</div>';

		html += '<div class="buttons">';
		html += '<div class="right"><a href="<?php echo site_url("foods"); ?>">View Menu</a></div>';
		html += '</div>';
		
		jQuery('#selectedLocation').html(html);
	}