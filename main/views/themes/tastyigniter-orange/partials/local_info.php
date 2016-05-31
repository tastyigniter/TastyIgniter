<div class="col-xs-12">
	<?php if (!empty($local_description)) { ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<h4 class="wrap-bottom border-bottom"><?php echo sprintf(lang('text_info_heading'), $location_name); ?></h4>
				<p><?php echo $local_description; ?></p>
			</div>
		</div>
	<?php } ?>
</div>

<div class="col-xs-12 wrap-none wrap-bottom">
	<div class="col-xs-12 col-sm-6">
		<?php if ($working_hours) { ?>
			<div class="panel panel-default panel-nav-tabs">
				<div class="panel-heading">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#opening-hours" data-toggle="tab"><?php echo lang('text_opening_hours'); ?></a></li>
						<?php if ($has_delivery) { ?>
							<li><a href="#delivery-hours" data-toggle="tab"><?php echo lang('text_delivery_hours'); ?></a></li>
						<?php } ?>
						<?php if ($has_collection) { ?>
							<li><a href="#collection-hours" data-toggle="tab"><?php echo lang('text_collection_hours'); ?></a></li>
						<?php } ?>
					</ul>
				</div>
				<div class="panel-body">
					<div class="tab-content">
						<?php foreach (array('opening', 'delivery', 'collection') as $type) { ?>
							<div id="<?php echo $type ?>-hours" class="tab-pane fade <?php echo ($type === 'opening') ? 'in active': ''; ?>">
								<div class="list-group">
									<?php if (!empty($working_hours[$type])) { ?>
										<?php foreach ($working_hours[$type] as $hour) { ?>
											<div class="list-group-item">
												<div class="row">
													<div class="col-xs-4"><?php echo $hour['day']; ?>:</div>
													<div class="col-xs-8">
														<?php if (!empty($hour['status'])) echo sprintf(lang('text_working_hour'), $hour['open'], $hour['close']); ?>
														<span class="small text-muted"><?php if (isset($hour['info']) AND $hour['info'] === 'closed') { echo lang('text_closed'); } else if (isset($hour['info']) AND $hour['info'] === '24_hours') { echo lang('text_24h'); }; ?></span>
													</div>
												</div>
											</div>
										<?php } ?>
									<?php } else if (empty($working_hours[$type])) { ?>
										<div class="list-group-item">
											<?php echo lang('text_same_as_opening_hours'); ?>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="col-xs-12 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="list-group">
					<?php if (!empty($working_type['opening']) AND $working_type['opening'] == '24_7') { ?>
						<div class="list-group-item"><?php echo lang('text_opens_24_7'); ?></div>
					<?php } ?>
					<?php if ($has_delivery) { ?>
						<div class="list-group-item"><i class="fa fa-clock-o fa-fw"></i>&nbsp;<b><?php echo lang('text_delivery_time'); ?></b><br />
							<?php if ($delivery_status === 'open') { ?>
								<?php echo sprintf(lang('text_in_minutes'), $delivery_time); ?>
							<?php } else if ($delivery_status === 'opening') { ?>
								<?php echo sprintf(lang('text_starts'), $delivery_time); ?>
							<?php } else { ?>
								<?php echo lang('text_closed'); ?>
							<?php } ?>
						</div>
					<?php } ?>
					<?php if ($has_collection) { ?>
						<div class="list-group-item"><i class="fa fa-clock-o fa-fw"></i>&nbsp;<b><?php echo lang('text_collection_time'); ?></b><br />
							<?php if ($collection_status === 'open') { ?>
								<?php echo sprintf(lang('text_in_minutes'), $collection_time); ?>
							<?php } else if ($collection_status === 'opening') { ?>
								<?php echo sprintf(lang('text_starts'), $collection_time); ?>
							<?php } else { ?>
								<?php echo lang('text_closed'); ?>
							<?php } ?>
						</div>
					<?php } ?>
					<?php if ($has_delivery) { ?>
						<div class="list-group-item"><i class="fa fa-clock-o fa-fw"></i>&nbsp;<b><?php echo lang('text_last_order_time'); ?></b><br />
							<?php echo $last_order_time; ?>
						</div>
					<?php } ?>
					<?php if ($payments) { ?>
						<div class="list-group-item"><i class="fa fa-paypal fa-fw"></i>&nbsp;<b><?php echo lang('text_payments'); ?></b><br />
							<?php echo $payments; ?>.
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 wrap-none">
		<?php if ($has_delivery) { ?>
			<div class="col-xs-12 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><b><?php echo lang('text_delivery_areas'); ?></b></h4>
					</div>
					<div class="panel-body">
						<div class="list-group">
							<?php if (!empty($delivery_areas)) { ?>
								<div class="list-group-item">
									<div class="row">
										<div class="col-xs-4"><b><?php echo lang('column_area_name'); ?></b></div>
										<div class="col-xs-8 wrap-none"><b><?php echo lang('column_area_charge'); ?></b></div>
									</div>
								</div>
								<?php foreach($delivery_areas as $key => $area) { ?>
									<div class="list-group-item">
										<div class="row">
											<div class="col-xs-4">
												<?php echo $area['name']; ?>
												<span class="badge" style="background-color: <?php echo $area['color']; ?>">&nbsp;&nbsp;</span>
											</div>
											<div class="col-xs-8 wrap-none"><?php echo $area['condition']; ?></div>
										</div>
									</div>
								<?php } ?>
							<?php } else { ?>
								<div class="list-group-item">
									<p><?php echo lang('text_no_delivery_areas'); ?></p>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6">
				<div id="map" class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><b><?php echo lang('text_delivery_map'); ?></b></h4>
					</div>
					<div class="panel-body">
						<div id="map-holder" style="height:300px;text-align:left;"></div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<script type="text/javascript">//<![CDATA[
	var map = null;
	var geocoder = null;
	var bounds = null;
	var markers = [];
	var deliveryAreas = [];
	var infoWindow = null;
	var colors = <?php echo json_encode($area_colors); ?>;
	var delivery_areas = <?php echo json_encode($delivery_areas); ?>;
	var local_name = "<?php echo $location_name; ?>";
	var latlng = new google.maps.LatLng(
		parseFloat("<?php echo $location_lat; ?>"),
		parseFloat("<?php echo $location_lng; ?>")
	);

    jQuery('a[href="#local-information"]').click(function() {
        if (map === null) {
            initializeMap();
        }
    });

    function initializeMap() {
        var html = "<b>" + local_name + "</b> <br/>" +
            "<?php echo $map_address; ?><br/>" +
            "<?php echo $location_telephone; ?>";

        var mapOptions = {
            scrollwheel: false,
            center: latlng,
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

	    map = new google.maps.Map(document.getElementById('map-holder'), mapOptions);

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

	    createSavedArea(delivery_areas)
    }

	function defaultAreaOptions() {
		return {
			visible: false,
			draggable: false,
			strokeOpacity: 0.8,
			strokeWeight: 3,
			fillOpacity: 0.15
		};
	}

	function resizeMap() {
		var allAreasBounds;

		if (!deliveryAreas.length){
			return;
		}

		allAreasBounds = deliveryAreas[0].getBounds();
		deliveryAreas.forEach(function(area) {
			var bounds = area.getBounds();
			allAreasBounds.union(bounds);
		});

		map.fitBounds(allAreasBounds);
	}

	function drawShapeArea(row, shape) {
		var options, shapeArea,
			color = (colors[row] == undefined) ? '#F16745' : colors[row];

		options = defaultAreaOptions();
		options.paths = shape;
		options.strokeColor = color;
		options.fillColor = color;
		shapeArea = new google.maps.Polygon(options);
		shapeArea.setMap(map);
		deliveryAreas.push(shapeArea);

		shapeArea.row = row;
		shapeArea.type = 'shape';

		return shapeArea;
	}

	function drawCircleArea(row, center, radius) {
		var options, circleArea,
			color = (colors[row] == undefined) ? '#F16745' : colors[row];

		options = defaultAreaOptions();
		options.strokeColor = color;
		options.fillColor = color;
		options.center = center;
		options.radius = radius;
		circleArea = new google.maps.Circle(options);
		circleArea.setMap(map);
		deliveryAreas.push(circleArea);

		circleArea.row = row;
		circleArea.type = 'circle';

		return circleArea;
	}

	function unserializedAreas(delivery_areas) {
		var savedAreas = [];

		for (i = 0; i < delivery_areas.length; i++) {
			var shape = delivery_areas[i].shape;
			var circle = delivery_areas[i].circle;
			var type = delivery_areas[i].type;

			try {
				shape = JSON.parse(shape);
				circle = JSON.parse(circle);
			} catch (e){
				console.log(e);
			}

			savedAreas.push({
				shape: shape[0].shape,
				center: circle[0].center,
				radius: circle[1].radius,
				type: type,
				row: i
			});
		}

		return savedAreas;
	}

	function createSavedArea(delivery_areas) {
		var savedAreas = unserializedAreas(delivery_areas);

		savedAreas.forEach(function(area) {
			var shapeArea, circleArea,
				shape, decodedPath;

			if (area.center != undefined && area.radius != undefined) {
				center = new google.maps.LatLng(area.center.lat, area.center.lng);
				circleArea = drawCircleArea(area.row, center, area.radius);
			}

			if (area.shape != undefined) {
				shape = area.shape.replace(/,/g,'\\').replace(/-/g,'\/');
				decodedPath = google.maps.geometry.encoding.decodePath(shape);

				shapeArea = drawShapeArea(area.row, decodedPath);
			}

			if (area.type == 'circle') {
				toggleVisibleMapArea(circleArea, 'circle');
			} else {
				toggleVisibleMapArea(shapeArea, 'shape');
			}
		});

		resizeMap();
	}

	function toggleVisibleMapArea(deliveryArea, type) {
		deliveryAreas.forEach(function(area) {
			if (area.row == deliveryArea.row) {
				area.setOptions({ visible: false });
				if (type != undefined && area.type == type) {
					area.setOptions({ visible: true });
				}
			}
		});
	}

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
//]]></script>