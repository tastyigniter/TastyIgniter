<?php if ($has_delivery OR $has_collection) { ?>
    <div class="col-sm-12 wrap-none wrap-bottom">
        <div class="col-sm-6">
            <dl class="dl-group">
                <?php if ($has_delivery) { ?>
                    <dd><i class="fa fa-clock-o fa-fw"></i>&nbsp;<b><?php echo lang('text_delivery_time'); ?></b><br /> <?php echo $delivery_time; ?> <?php echo lang('text_minutes'); ?></dd>
                <?php } ?>
                <dd><i class="fa fa-clock-o fa-fw"></i>&nbsp;<b><?php echo lang('text_collection_time'); ?></b><br />
                    <?php if ($has_collection) { ?>
                        <?php echo $collection_time; ?> <?php echo lang('text_minutes'); ?>
                    <?php } else { ?>
                        <?php echo lang('text_only_delivery_is_available'); ?>
                    <?php } ?>
                </dd>
                <?php if ($has_delivery) { ?>
                    <dd><i class="fa fa-clock-o fa-fw"></i>&nbsp;<b><?php echo lang('text_last_order_time'); ?></b><br /> <?php echo $last_order_time; ?></dd>
                    <dd><i class="fa fa-paypal fa-fw"></i>&nbsp;<b><?php echo lang('text_payments'); ?></b><br /> <?php echo $payments; ?></dd>
                <?php } ?>
                <?php if (!empty($opening_type) AND $opening_type == '24_7') { ?>
                    <dd><?php echo lang('text_opens_24_7'); ?></dd>
                <?php } ?>
            </dl>
        </div>

        <div class="col-sm-6">
            <?php if ($has_delivery AND $opening_hours) { ?>
                <p><i class="fa fa-clock-o fa-fw"></i>&nbsp;<strong><?php echo lang('text_delivery_hours'); ?></strong></p>
                <dl class="dl-horizontal opening-hour">
                    <?php foreach ($opening_hours as $opening_hour) { ?>
                        <dt><?php echo $opening_hour['day']; ?>:</dt>
                        <dd><?php echo $opening_hour['time']; ?> <span class="small text-muted"><?php echo $opening_hour['type']; ?></span></dd>
                    <?php } ?>
                </dl>
            <?php } ?>
        </div>

        <div class="col-sm-12 wrap-none">
	        <?php if ($has_delivery) { ?>
	            <div class="col-sm-6">
                    <h4 class="wrap-bottom border-bottom"><?php echo lang('text_delivery_areas'); ?></h4>

                    <div class="row">
                        <div class="col-sm-5"><b><?php echo lang('column_area_name'); ?></b></div>
                        <div class="col-sm-4"><b><?php echo lang('column_area_charge'); ?></b></div>
                        <div class="col-sm-3"><b><?php echo lang('column_area_min_total'); ?></b></div>
                        <?php if (!empty($delivery_areas)) { ?>
                            <?php foreach($delivery_areas as $key => $area) { ?>
                                <div class="col-sm-12 wrap-none">
                                    <div class="col-sm-5">
	                                    <?php echo $area['name']; ?>
	                                    <span class="badge" style="background-color: <?php echo $area['color']; ?>">&nbsp;&nbsp;</span>
                                    </div>
                                    <div class="col-sm-4"><?php echo $area['charge']; ?></div>
                                    <div class="col-sm-3"><?php echo $area['min_amount']; ?></div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="col-sm-12">
                                <br /><p><?php echo lang('text_no_delivery_areas'); ?></p>
                            </div>
                        <?php } ?>
                    </div>
	            </div>

	            <div class="col-sm-6 wrap-top">
	                <div id="map" class="">
	                    <div id="map-holder" style="height:370px;text-align:left;"></div>
	                </div>
	            </div>
	        <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <div class="col-sm-12">
        <p class="alert alert-info"><?php echo lang('text_offers_no_types'); ?></p>
    </div>
<?php } ?>

<div class="col-sm-12">
    <h4 class="wrap-bottom border-bottom"><?php echo sprintf(lang('text_info_heading'), $location_name); ?></h4>
    <p><?php echo $local_description; ?></p>
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
        }

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
				center = new google.maps.LatLng(area.center.lat, area.center.lng)
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