<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Location</a></li>
				<li><a href="#working-hours" data-toggle="tab">Working Hours</a></li>
				<li><a href="#order" data-toggle="tab">Order</a></li>
				<li><a href="#reservation" data-toggle="tab">Reservation</a></li>
				<li><a id ="open-map" href="#covered-area" data-toggle="tab">Covered Area</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="location_name" id="input-name" class="form-control" value="<?php echo set_value('location_name', $location_name); ?>" />
							<?php echo form_error('location_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-address-1" class="col-sm-2 control-label">Address 1:</label>
						<div class="col-sm-5">
							<input type="text" name="address[address_1]" id="input-address-1" class="form-control" value="<?php echo set_value('address[address_1]', $location_address_1); ?>" />
							<?php echo form_error('address[address_1]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-address-2" class="col-sm-2 control-label">Address 2:</label>
						<div class="col-sm-5">
							<input type="text" name="address[address_2]" id="input-address-2" class="form-control" value="<?php echo set_value('address[address_2]', $location_address_2); ?>" />
							<?php echo form_error('address[address_2]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-city" class="col-sm-2 control-label">City:</label>
						<div class="col-sm-5">
							<input type="text" name="address[city]" id="input-city" class="form-control" value="<?php echo set_value('address[city]', $location_city); ?>" />
							<?php echo form_error('address[city]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-postcode" class="col-sm-2 control-label">Postcode:</label>
						<div class="col-sm-5">
							<input type="text" name="address[postcode]" id="input-postcode" class="form-control" value="<?php echo set_value('address[postcode]', $location_postcode); ?>" />
							<?php echo form_error('address[postcode]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-country" class="col-sm-2 control-label">Country:</label>
						<div class="col-sm-5">
							<select name="address[country]" id="input-country" class="form-control">
								<?php foreach ($countries as $country) { ?>
								<?php if ($country['country_id'] === $country_id) { ?>
									<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('address[country]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email" class="col-sm-2 control-label">Email:</label>
						<div class="col-sm-5">
							<input type="text" name="email" id="input-email" class="form-control" value="<?php echo set_value('email', $location_email); ?>" />
							<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-telephone" class="col-sm-2 control-label">Telephone:</label>
						<div class="col-sm-5">
							<input type="text" name="telephone" id="input-telephone" class="form-control" value="<?php echo set_value('telephone', $location_telephone); ?>" />
							<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-description" class="col-sm-2 control-label">Description:</label>
						<div class="col-sm-5">
							<textarea name="description" id="input-description" class="form-control" rows="5"><?php echo set_value('description', $description); ?></textarea>
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Status:</label>
						<div class="col-sm-5">
							<select name="location_status" id="input-status" class="form-control">
								<option value="0" <?php echo set_select('location_status', '0'); ?> >Disabled</option>
								<?php if ($location_status === '1') { ?>
									<option value="1" <?php echo set_select('location_status', '1', TRUE); ?> >Enabled</option>
								<?php } else { ?>  
									<option value="1" <?php echo set_select('location_status', '1'); ?> >Enabled</option>
								<?php } ?>  
							</select>
							<?php echo form_error('location_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
		
				<div id="working-hours" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Day</label>
						<div class="form-mini col-sm-5">
							<div class="col-sm-2">
								<b>Open Hour</b>
							</div>
							<div class="col-sm-2">
								<b>Close Hour</b>
							</div>
						</div>
					</div>
					<?php foreach ($hours as $hour) { ?>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label"><?php echo $hour['day']; ?></label>
						<div class="form-mini col-sm-5">
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" name="hours[<?php echo $hour['day']; ?>][open]" id="" class="form-control hours" value="<?php echo set_value('hours[][open]', $hour['open']); ?>" />
									<span id="discount-addon" class="input-group-addon"><i class="fa fa-clock-o"></i></span>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" name="hours[<?php echo $hour['day']; ?>][close]" id="" class="form-control hours" value="<?php echo set_value('hours[][close]', $hour['close']); ?>" />
									<span id="discount-addon" class="input-group-addon"><i class="fa fa-clock-o"></i></span>
								</div>
							</div><br /><br />
							<?php echo form_error('hours['.$hour['day'].'][open]', '<span class="text-danger">', '</span>'); ?>
							<?php echo form_error('hours['.$hour['day'].'][close]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<?php } ?>
				</div>

				<div id="order" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-offer-delivery" class="col-sm-2 control-label">Offer Delivery:</label>
						<div class="col-sm-5">
							<select name="offer_delivery" id="input-offer-delivery" class="form-control">
								<?php if ($offer_delivery === '1') { ?>
									<option value="0" <?php echo set_select('offer_delivery', '0'); ?> >No</option>
									<option value="1" <?php echo set_select('offer_delivery', '1', TRUE); ?> >Yes</option>
								<?php } else { ?>  
									<option value="0" <?php echo set_select('offer_delivery', '0', TRUE); ?> >No</option>
									<option value="1" <?php echo set_select('offer_delivery', '1'); ?> >Yes</option>
								<?php } ?>  
							</select>
							<?php echo form_error('offer_delivery', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-offer-collection" class="col-sm-2 control-label">Offer Collection:</label>
						<div class="col-sm-5">
							<select name="offer_collection" id="input-offer-collection" class="form-control">
								<?php if ($offer_collection === '1') { ?>
									<option value="0" <?php echo set_select('offer_collection', '0'); ?> >No</option>
									<option value="1" <?php echo set_select('offer_collection', '1', TRUE); ?> >Yes</option>
								<?php } else { ?>  
									<option value="0" <?php echo set_select('offer_collection', '0', TRUE); ?> >No</option>
									<option value="1" <?php echo set_select('offer_collection', '1'); ?> >Yes</option>
								<?php } ?>  
							</select>
							<?php echo form_error('offer_collection', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-ready-time" class="col-sm-2 control-label">Ready Time:
							<span class="help-block">Set in minutes when an order will be delivered/collected after being placed</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="ready_time" id="input-ready-time" class="form-control" value="<?php echo set_value('ready_time', $ready_time); ?>" size="5" />
							<?php echo form_error('ready_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-last-order-time" class="col-sm-2 control-label">Last Order Time:
							<span class="help-block">Set the last order time in minutes before close hour, otherwise use close hour.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="last_order_time" id="input-last-order-time" class="form-control" value="<?php echo set_value('last_order_time', $last_order_time); ?>" size="5" />
							<?php echo form_error('last_order_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-delivery-charge" class="col-sm-2 control-label">Delivery Charge:
							<span class="help-block">Set to "0.00" for free delivery charge</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="delivery_charge" id="input-delivery-charge" class="form-control" value="<?php echo set_value('delivery_charge', $delivery_charge); ?>" size="5" />
							<?php echo form_error('delivery_charge', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-min-delivery-total" class="col-sm-2 control-label">Min Delivery Total:
							<span class="help-block">Set to "0.00" for no minimum delivery charge</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="min_delivery_total" id="input-min-delivery-total" class="form-control" value="<?php echo set_value('min_delivery_total', $min_delivery_total); ?>" size="5" />
							<?php echo form_error('min_delivery_total', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!--<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Latitude:</label>
						<div class="col-sm-5">
							<?php echo $location_lat; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Longitude:</label>
						<div class="col-sm-5">
							<?php echo $location_lng; ?>
						</div>
					</div>-->
				</div>
		
				<div id="reservation" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-table" class="col-sm-2 control-label">Tables:</label>
						<div class="col-sm-5">
							<input type="text" name="table" value="" id="input-table" class="form-control" />
							<?php echo form_error('table', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div id="table-box" class="col-sm-5">
							<div class="table-responsive panel-selected">
								<table class="table table-striped table-border">
									<thead>
										<tr>
											<th>Name</th>
											<th>Minimum</th>
											<th>Capacity</th>
											<th>Remove</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($tables as $table) { ?>
										<?php if (in_array($table['table_id'], $location_tables)) {?>
										<tr id="table-box<?php echo $table['table_id']; ?>">
											<td><?php echo $table['table_name']; ?></td>
											<td><?php echo $table['min_capacity']; ?></td>
											<td><?php echo $table['max_capacity']; ?></td>
											<td class="img"><a class="btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a><input type="hidden" name="tables[]" value="<?php echo $table['table_id']; ?>" /></td>
										</tr>
										<?php } ?>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-interval" class="col-sm-2 control-label">Time Interval:
							<span class="help-block">Set in minutes the time between each reservation</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="reservation_interval" id="input-reserve-interval" class="form-control" value="<?php echo set_value('reservation_interval', $reservation_interval); ?>" />
							<?php echo form_error('reservation_interval', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-turn" class="col-sm-2 control-label">Turn Time:
							<span class="help-block">Set in minutes the turn time for each reservation</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="reservation_turn" id="input-reserve-turn" class="form-control" value="<?php echo set_value('reservation_turn', $reservation_turn); ?>" />
							<?php echo form_error('reservation_turn', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
	
				<div id="covered-area" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-radius" class="col-sm-2 control-label">Radius:
							<span class="help-block">Set the search radius in miles or kilometers, to overwrite the GLOBAL search radius value or leave blank to use GLOBAL search radius value.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="location_radius" id="input-radius" class="form-control" value="<?php echo set_value('location_radius', $location_radius); ?>" />
							<?php echo form_error('location_radius', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<?php if ($is_covered_area) { ?>
						<input type="hidden" name="covered_area[path]" value="<?php echo set_value('covered_area[path]', $covered_area['path']); ?>" />
						<input type="hidden" name="covered_area[pathArray]" value="<?php echo set_value('covered_area[pathArray]', $covered_area['pathArray']); ?>" />
						<div id="map" style="width:100%;height:470px;"><div id="map-holder" style="height:470px;"></div></div> 
					<?php } else { ?>	
						<p class="alert alert-info">Covered area map will be visible after location has been saved.</p>  	
					<?php } ?>	
				</div>
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
		$('#table-box table tbody').append('<tr id="table-box' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td>' + ui.item.min + '</td><td>' + ui.item.max + '</td><td class="img">' + '<a class="btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>' + '<input type="hidden" name="tables[]" value="' + ui.item.value + '" /></td></tr>');

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
<?php echo $footer; ?>