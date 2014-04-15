<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">Location</a></li>
				<li><a rel="#working-hours">Working Hours</a></li>
				<li><a rel="#order">Order</a></li>
				<li><a rel="#reservation">Reservation</a></li>
				<li><a rel="#payment">Payment</a></li>
				<li><a id ="open-map" rel="#covered-area">Covered Area</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tr>
					<td><b>Name:</b></td>
					<td><input type="text" name="location_name" value="<?php echo set_value('location_name', $location_name); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Address 1:</b></td>
					<td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]', $location_address_1); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Address 2:</b></td>
					<td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]', $location_address_2); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>City:</b></td>
					<td><input type="text" name="address[city]" value="<?php echo set_value('address[city]', $location_city); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Postcode:</b></td>
					<td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]', $location_postcode); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Country:</b></td>
					<td><select name="address[country]">
					<?php foreach ($countries as $country) { ?>
					<?php if ($country['country_id'] === $country_id) { ?>
						<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
					<?php } ?>  
					<?php } ?>  
					</selec></td>
				</tr>
				<tr>
					<td><b>Email:</b></td>
					<td><input type="text" name="email" value="<?php echo set_value('email', $location_email); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Telephone:</b></td>
					<td><input type="text" name="telephone" value="<?php echo set_value('telephone', $location_telephone); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Status:</b></td>
					<td><select name="location_status">
						<option value="0" <?php echo set_select('location_status', '0'); ?> >Disabled</option>
					<?php if ($location_status === '1') { ?>
						<option value="1" <?php echo set_select('location_status', '1', TRUE); ?> >Enabled</option>
					<?php } else { ?>  
						<option value="1" <?php echo set_select('location_status', '1'); ?> >Enabled</option>
					<?php } ?>  
					</select></td>
				</tr>
			</table>
		</div>
		
		<div id="working-hours" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Day:</b></td>
					<?php foreach ($hours['day'] as $key => $day) { ?>
						<td><b><?php echo $day; ?></b></td>
					<?php } ?>
				</tr>
				<tr>
					<td><b>Open Hour:</b></td>
					<?php foreach ($hours['open'] as $key => $open) { ?>
						<td><input type="text" name="hours[open][]" value="<?php echo set_value('hours[open][]', $open); ?>" class="textfield hours" size="4" /></td>
					<?php } ?>
				</tr>
				<tr>
					<td><b>Close Hour:</b></td>
					<?php foreach ($hours['close'] as $key => $close) { ?>
						<td><input type="text" name="hours[close][]" value="<?php echo set_value('hours[close][]', $close); ?>" class="textfield hours" size="4" /></td>
					<?php } ?>
				</tr>
			</table>
		</div>

		<div id="order" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Offer Delivery:</b></td>
					<td><select name="offer_delivery">
					<?php if ($offer_delivery === '1') { ?>
						<option value="0" <?php echo set_select('offer_delivery', '0'); ?> >No</option>
						<option value="1" <?php echo set_select('offer_delivery', '1', TRUE); ?> >Yes</option>
					<?php } else { ?>  
						<option value="0" <?php echo set_select('offer_delivery', '0', TRUE); ?> >No</option>
						<option value="1" <?php echo set_select('offer_delivery', '1'); ?> >Yes</option>
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><b>Offer Collection:</b></td>
					<td><select name="offer_collection">
					<?php if ($offer_collection === '1') { ?>
						<option value="0" <?php echo set_select('offer_collection', '0'); ?> >No</option>
						<option value="1" <?php echo set_select('offer_collection', '1', TRUE); ?> >Yes</option>
					<?php } else { ?>  
						<option value="0" <?php echo set_select('offer_collection', '0', TRUE); ?> >No</option>
						<option value="1" <?php echo set_select('offer_collection', '1'); ?> >Yes</option>
					<?php } ?>  
					</select></td>
				</tr>
				<tr>
					<td><b>Ready Time:</b><br />
					<font size="1">Set in minutes when an order will be delivered/collected after being placed</font></td>
					<td><input type="text" name="ready_time" value="<?php echo set_value('ready_time', $ready_time); ?>" class="textfield" size="5" /></td>
				</tr>
				<tr>
					<td><b>Last Order Time:</b><br />
					<font size="1">Set the last order time in minutes before close hour, otherwise use close hour.</font></td>
					<td><input type="text" name="last_order_time" value="<?php echo set_value('last_order_time', $last_order_time); ?>" class="textfield" size="5" /></td>
				</tr>
				<tr>
					<td><b>Delivery Charge:</b><br />
					<font size="1">Set to "0.00" for free delivery charge</font></td>
					<td><input type="text" name="delivery_charge" value="<?php echo set_value('delivery_charge', $delivery_charge); ?>" class="textfield" size="5" /></td>
				</tr>
				<tr>
					<td><b>Min Delivery Total:</b><br />
					<font size="1">Set to "0.00" for no minimum delivery charge</font></td>
					<td><input type="text" name="min_delivery_total" value="<?php echo set_value('min_delivery_total', $min_delivery_total); ?>" class="textfield" size="5" /></td>
				</tr>
				<!--<tr>
					<td><b>Latitude:</b></td>
					<td><?php echo $location_lat; ?></td>
				</tr>
				<tr>
					<td><b>Longitude:</b></td>
					<td><?php echo $location_lng; ?></td>
				</tr>-->
			</table>
		</div>
		
		<div id="reservation" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Tables:</b></td>
					<td><input type="text" name="table" value="" class="textfield" size="10" /></td>
				</tr>
				<tr>
					<td></td>
					<td><div id="table-box" class="selectbox">
					<table>
					<tr>
						<th>Name</th>
						<th>Minimum</th>
						<th>Capacity</th>
						<th>Remove</th>
					</tr>
					<?php foreach ($tables as $table) { ?>
					<?php if (in_array($table['table_id'], $location_tables)) {?>
						<tr id="table-box<?php echo $table['table_id']; ?>">
							<td><?php echo $table['table_name']; ?></td>
							<td><?php echo $table['min_capacity']; ?></td>
							<td><?php echo $table['max_capacity']; ?></td>
							<td class="img"><img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$(this).parent().parent().remove();" /><input type="hidden" name="tables[]" value="<?php echo $table['table_id']; ?>" /></td>
						</tr>
					<?php } ?>
					<?php } ?>
					</table>
					</div></td>
				</tr>
				<tr>
					<td><b>Time Interval:</b><br />
					<font size="1">Set in minutes the time between each reservation</font></td>
					<td><input type="text" name="reserve_interval" value="<?php echo set_value('reserve_interval', $reserve_interval); ?>" class="textfield" size="5" /></td>
				</tr>
				<tr>
					<td><b>Turn Time:</b><br />
					<font size="1">Set in minutes the turn time for each reservation</font></td>
					<td><input type="text" name="reserve_turn" value="<?php echo set_value('reserve_turn', $reserve_turn); ?>" class="textfield" size="5" /></td>
				</tr>
			</table>
		</div>
	
		<div id="payment" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Coming Soon:</b></td>
					<td>Option to select payment gateways for each location.</td>
				</tr>
			</table>
		</div>
		
		<div id="covered-area" class="wrap_content" style="display:none;">
			<table class="form">
				<tr>
					<td><b>Location Radius:</b><br />
					<font size="1">Set the search radius in miles or kilometers, or leave blank to use search radius value in settings. This overwrite the search radius in Settings.</font></td>
					<td><input type="text" name="location_radius" value="<?php echo set_value('location_radius', $location_radius); ?>" class="textfield" /></td>
				</tr>
			</table>
			<?php if ($is_covered_area) { ?>
				<input type="hidden" name="covered_area[path]" value="<?php echo set_value('covered_area[path]', $covered_area['path']); ?>" />
				<input type="hidden" name="covered_area[pathArray]" value="<?php echo set_value('covered_area[pathArray]', $covered_area['pathArray']); ?>" />
				<div id="map" style="width:100%;height:470px;"><div id="map-holder" style="height:470px;"></div></div> 
			<?php } else { ?>	
				<p align="center"><font size="3" color="red">Save location to enable covered area</font></p>  	
			<?php } ?>	
		</div>


	</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.hours').timepicker({
		timeFormat: 'HH:mm',
	});
});

$('#tabs a').tabs();
//--></script>
<script type="text/javascript"><!--
$('input[name=\'table\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/tables/autocomplete"); ?>?table_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						value: item.table_id,
						label: item.table_name,
						min: item.min_capacity,
						max: item.max_capacity
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#table-box' + ui.item.value).remove();
		$('#table-box table').append('<tr id="table-box' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td>' + ui.item.min + '</td><td>' + ui.item.max + '</td><td class="img">' + '<img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$(this).parent().parent().remove();" />' + '<input type="hidden" name="tables[]" value="' + ui.item.value + '" /></td></tr>');

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<?php if ($is_covered_area) { ?>
<script src="http://maps.googleapis.com/maps/api/js?v=3<?php echo $map_key; ?>&sensor=false&region=GB&libraries=geometry"></script>
<script type="text/javascript">//<![CDATA[
var map = null,
inputArea = $('input[name="covered_area[path]"]').val(),
coveredAreas = [],
setCoveredArea,
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

	$('#update-box form').on('submit', saveCoveredAreas);
		
	loadMap(inputArea);
	setControlButtons(setCoveredArea);
}


function saveCoveredAreas(){
	var inputPath = $('input[name="covered_area[path]"]'),
	inputPathArray = $('input[name="covered_area[pathArray]"]'),
	serialized;
	try {
		path = serializePath();
		pathArray = serializePathArray();
	} catch (ex) {
		console.log(ex);
		alert(ex);
		// don't save
		ex.preventDefault();
		return false;
	}
	
	inputPath.val(path);
	inputPathArray.val(pathArray);
}

function addCoveredAreaToMap(coveredArea, map){
	coveredAreas.push(coveredArea);
	setCoveredArea = coveredArea;
	coveredArea.setMap(map);
}

function createCoveredArea(map){
	var coveredArea;
	coveredArea = createDefaultCoveredArea(map);
	addCoveredAreaToMap(coveredArea, map);

	//return coveredArea;
}

function loadMap(inputArea){
	var serializedArea;
	serializedArea = createSerializedArea(inputArea);
	
	if (!serializedArea) {
		createCoveredArea(map);
	}
}

function setControlButtons(coveredArea) {
	editButton = new editControlButton(coveredArea, map);
	saveButton = new saveControlButton(coveredArea, map);
}

function createDefaultCoveredArea(map){
	var coveredCircle, ne, sw, scale = 0.15, windowWidth, windowHeight,
	widthMargin, heightMargin, top, bottom, left, right, areaCoords, options, coveredArea;

	coveredCircle = new google.maps.Circle({center: centerLatLng, radius: 1000});
	ne = coveredCircle.getBounds().getNorthEast();
	sw = coveredCircle.getBounds().getSouthWest();
	scale = 0.15;
	windowWidth = ne.lng() - sw.lng();
	windowHeight = ne.lat() - sw.lat();
	widthMargin = windowWidth * scale;
	heightMargin = windowHeight * scale;
	top = ne.lat() - heightMargin;
	bottom = sw.lat() + heightMargin;
	left = sw.lng() + widthMargin;
	right = ne.lng() - widthMargin;
	areaCoords = [
		new google.maps.LatLng(top, right),
		new google.maps.LatLng(bottom, right),
		new google.maps.LatLng(bottom, left),
		new google.maps.LatLng(top, left)
	];

	options = defaultPolygonOptions();
	//options.editable = editable;
	options.paths = areaCoords;
	coveredArea = new google.maps.Polygon(options);

	return coveredArea;
}

function defaultPolygonOptions(){
	return {
		strokeColor: '#595959',
		strokeOpacity: 0.8,
		strokeWeight: 3,
		fillColor: '#898989',
		fillOpacity: 0.35
	};
}

function controlButton(map, text, title, clickEvent) {

	this.controlDiv = document.createElement('div');
	var controlDiv = this.controlDiv;
	controlDiv.index = 1;

	controlDiv.style.padding = '5px';

	var controlUI = document.createElement('div');
	controlUI.style.backgroundColor = 'white';
	controlUI.style.borderStyle = 'solid';
	controlUI.style.borderWidth = '1px';
	controlUI.style.cursor = 'pointer';
	controlUI.style.textAlign = 'center';
	controlUI.title = title;
	controlDiv.appendChild(controlUI);

	var controlText = document.createElement('div');
	controlText.style.fontSize = '14px';
	controlText.style.fontWeight = 'normal';
	controlText.style.paddingLeft = '6px';
	controlText.style.paddingRight = '6px';
	controlText.innerHTML = text;
	controlUI.appendChild(controlText);

	google.maps.event.addDomListener(controlUI, 'click', clickEvent);
	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);
}

function saveControlButton(coveredArea, map) {
	var control = new controlButton(map, '<b>Save</b>', 'Click to save the delivery area', function(event) {
    	saveCoveredAreas();
    	coveredArea.setEditable(false);
	});
	return control;
}

function editControlButton(coveredArea, map){
	var control = new controlButton(map, '<b>Edit</b>', 'Click to edit the delivery area', function(event) {
    	coveredArea.setEditable(true);
	});
	return control;
}

function resizeMap(map, coveredAreas){
	var allAreasBounds;

	if (!coveredAreas.length){
		return;
	}

	allAreasBounds = coveredAreas[0].getBounds();
	coveredAreas.forEach(function(coveredArea){
		var bounds = coveredArea.getBounds();
		allAreasBounds.union(bounds);
	});

	map.fitBounds(allAreasBounds);

}

function clearCoveredArea(){
	coveredAreas.forEach(function(coveredArea){
		coveredArea.setMap(null);
	});
}

function serializePath() {
	var output = [];

	coveredAreas.forEach(function(coveredArea) {
		var path, encodedPath;
		path = google.maps.geometry.encoding.encodePath(coveredArea.getPath());
		encodedPath = path.replace(/\\/g,',').replace(/\//g,'-');

		output.push({path: encodedPath});
	});
	output = JSON.stringify(output)
	return output;
}

function serializePathArray() {
	var output = [];

	coveredAreas.forEach(function(coveredArea) {
		var vertices = coveredArea.getPath();
		
		for (var i =0; i < vertices.getLength(); i++) {
			var xy = vertices.getAt(i);
		
			output.push({
				lat: xy.lat(),
				lng: xy.lng()
			});
		}
	});
	output = JSON.stringify(output)
	return output;
}

function createSerializedArea(serializedJson) {
	var coveredInput = [],
	coveredArea;
	
	if (!serializedJson) {
		return;
	}
	try {
		coveredInput = JSON.parse(serializedJson);
	} catch (e){
		console.log(e);
		alert('Invalid json format for serializedPaths');
	}

	clearCoveredArea();
	coveredInput.forEach(function(inputArea){
		var options,
		decodedPath;
		
		if (!inputArea.path){
			return;
		}
		
		var path, decodedPath;
		path = inputArea.path.replace(/,/g,'\\').replace(/-/g,'\/');
		decodedPath = google.maps.geometry.encoding.decodePath(path);

		options = defaultPolygonOptions();
		options.path = decodedPath;
		coveredArea = new google.maps.Polygon(options);
		addCoveredAreaToMap(coveredArea, map);
	});
	
    resizeMap(map, coveredAreas);

	return coveredArea;
}
//]]></script>
<?php } ?>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.hours').timepicker({
		timeFormat: 'HH:mm',
	});
});
//--></script>