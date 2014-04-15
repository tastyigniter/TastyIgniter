<div class="img_outer">
<div id="local-box">
	<div id="local-alert"><?php echo $local_alert; ?></div>
	<div id="local-info">
		<div class="display-local" style="display: <?php echo ($local_info ? 'block' : 'none'); ?>">
			<div class="one left">
				<h3><?php echo $local_info['location_name']; ?></h3>	
				<span class="address"><?php echo $local_info['location_address_1']; ?>, <?php echo $local_info['location_city']; ?>, <?php echo $local_info['location_postcode']; ?></span>
				<a onclick="openMap();" class="icon-map" id="open-map"></a><br />
				<?php echo $local_info['location_telephone']; ?><br />
			</div>
			<div class="two center">
				<span class=""><?php echo $text_delivery; ?></span><br />
				<span class=""><?php echo $text_collection; ?></span><br />
			</div>
			<div class="three left">
				<span class="is-open"><?php echo $text_open_or_close; ?></span><br />
				<span class=""><?php echo $text_delivery_charge; ?>: <?php echo $delivery_charge; ?></span><br />
				<span class=""><?php echo $text_min_total; ?>: <?php echo $min_total; ?></span>
			</div>
			<div class="four center">
				<a class="button2" onclick="clearLocal();" id="check-postcode"><?php echo $button_check_postcode; ?></a><br />
				<font size="1">
					<?php echo $text_total_review; ?>
				</font>
			</div>
		</div>

		<form id="location-form" method="POST" action="<?php echo site_url('main/local_module/distance'); ?>">
		<div class="check-local" style="display: <?php echo ($local_info ? 'none' : 'block'); ?>">
			<div class="one left">
				<span><b><?php echo $text_postcode; ?></b></span>
			</div>
			<div class="two center">
				<input type="text" id="postcodeInput" name="postcode" value="<?php echo $postcode; ?>" /><br />
				<font size="1"><?php echo $text_postcode_warning; ?></font>
			</div>
			<div class="three center">
				<input type="button" onclick="searchLocal();" value="<?php echo $text_find; ?>" />
			</div>
		</div>
		</form>
	</div>
	<div id="local-map" class="right" style="display:none;"><div id="map-holder" style="height:350px;"></div></div>   	
</div>
</div>
<script src="http://maps.googleapis.com/maps/api/js?v=3<?php echo $map_key; ?>&sensor=false&region=GB"></script>
<script type="text/javascript">//<![CDATA[
	var map = null;
	var geocoder = null;
	var bounds = null;
	var markers = [];
	var infoWindow = null;
	var json = <?php echo json_encode($local_info); ?>;
	if (json === null) {
		var latlng = null
	} else {
		var latlng = new google.maps.LatLng(parseFloat(json['location_lat']), parseFloat(json['location_lng'])); 
	}
	
	jQuery('#open-map').click(function() {
		$('#local-map').show(function() {
			if (map === null) {
				initializeMap();
			}
		});
	});

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

    //google.maps.event.addDomListener(document.getElementById('open-map'), 'click', initializeMap);
//]]></script>
<script src="<?php echo base_url("assets/js/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript">//<!--
function openMap() {
	$('#open-map').fancybox({
		width: 460,
		height: 420,
  		type: 'inline', 
 		href:"#local-map",
 		autoSize: false,
		afterClose: function() {
			//$('#local-map').empty();
		}
	});
}

function searchLocal() {
	
	var postcode = $('input[name=\'postcode\']').val();

	$.ajax({
		url: js_site_url + 'main/local_module/distance',
		type: 'post',
		data: 'postcode=' + postcode,
		dataType: 'json',
		success: function(json) {
			$('.local-alert').remove();

			if(json['redirect']) {
				window.location.href = json['redirect'];
			}
					
			if (json['error']) {
				$('#local-info').before('<div class="local-alert">' + json['error'] + '</div>');
			
				$('.error').fadeIn('slow');
							
				//$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}
		
			$('#local-info').load(js_site_url + 'main/local_module #local-info > *');
		}
	});
}
//--!></script>