<?php echo $header; ?>
<?php echo $content_top; ?>
<?php if (!$local_location) { ?>
	<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<?php } ?>

<div id="notification" class="row">
	<div class="alert alert-dismissable">
	<?php if (!empty($alert) OR !empty($local_alert)) { ?>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $alert; ?>
		<?php if (!empty($local_alert)) { ?>
			<div class="wrap-all  bg-danger"><?php echo $local_alert; ?></div>
		<?php } ?>
	<?php } ?>
	</div>
</div>

<?php if (!$local_location) { ?>
<div class="row content location-list">
	<?php if ($locations) {?>
		<?php foreach ($locations as $location) { ?>
			<div class="panel panel-local">
				<div class="panel-heading">
					<h4><?php echo $location['location_name']; ?>
						<span class="pull-right"><?php echo $location['open_or_closed']; ?></span>
					</h4>
				</div>

				<div class="panel-body">
					<div class="col-md-4">
						<dl>
							<dd><span class="text-muted"><?php echo $location['address']; ?></span></dd>
							<dd>
								<div class="rating rating-sm">
									<span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star-half-o"></span><span class="fa fa-star-o"></span>
								</div>
								<span><?php echo $location['total_reviews']; ?></span>
							</dd>
						</dl>
					</div>
					<div class="col-md-3">
						<dl>
							<dd class="text-info">
								<span class="fa fa-clock-o"></span>&nbsp;&nbsp;
								<?php if ($location['opening_time'] == '00:00' AND $location['closing_time'] == '23:59') { ?>
									<span><?php echo $text_24h; ?></span>
								<?php } else { ?>
									<span><?php echo $location['opening_time']; ?> - <?php echo $location['closing_time']; ?></span>
								<?php } ?>
							</dd>
							<dd><span><?php echo $location['delivery_charge']; ?></span></dd>
						</dl>
					</div>
					<div class="col-md-3">
						<dl>
							<dd><?php echo $location['offers']; ?></dd>
							<dd><span><?php echo $text_min_total; ?>: <?php echo $location['min_total']; ?></span></dd>
							<dd><span><?php echo $location['delivery_time']; ?></span></dd>
						</dl>
					</div>
					<div class="col-md-2 text-center">
						<dl>
							<dd><a class="btn btn-success btn-checkout" href="<?php echo $location['href']; ?>"><?php echo $button_view_menu; ?></a></dd>
						</dl>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		<?php } ?>
	<?php } else { ?>
		<p><?php echo $text_empty; ?></p>
	<?php } ?>
</div>
<?php } else { ?>
<div class="row margin-top">
	<ul class="nav nav-tabs menus-tabs text-sm" role="tablist">
		<li><a href="<?php echo site_url('main/menus'); ?>">Menu</a></li>
		<li class="active"><a href="<?php echo site_url('main/local'); ?>">Info</a></li>
		<li><a href="<?php echo site_url('main/local/reviews'); ?>">Reviews</a></li>
	</ul>
</div>

<div class="row content wrap-horizontal">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-md-8 page-content">
		<div class="row wrap-vertical wrap-bottom" style="display: block;">
			<div class="page-header">
				<h4><?php echo $text_local; ?></h4>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="">
						<p><?php echo $description; ?></p><br/>

						<?php if ($opening_hours) { ?>
						<div class="panel">
							<?php if (!empty($opening_type) AND $opening_type == '24_7') { ?>
								<p><?php echo $text_open24_7; ?></p>
							<?php } else { ?>
								<strong><?php echo $text_opening_hours; ?></strong>
								<dl class="dl-horizontal opening-hour">
									<?php foreach ($opening_hours as $opening_hour) { ?>
										<dt><?php echo $opening_hour['day']; ?>:</dt>
										<dd><?php echo $opening_hour['time']; ?></dd>
									<?php } ?>
								</dl>
							<?php } ?>
						</div>
						<?php } ?>

						<div class="panel wrap-horizontal">
							<div class="btn-group btn-group-md" data-toggle="buttons">
								<?php if ($order_type === '1' AND ($has_delivery AND $has_collection)) { ?>
									<label class="btn btn-default active">
										<input type="radio" name="order_type" value="1" checked="checked">&nbsp;&nbsp;<?php echo $text_delivery; ?>
									</label>
									<label class="btn btn-default">
										<input type="radio" name="order_type" value="2">&nbsp;&nbsp;<?php echo $text_collection; ?>
									</label>
								<?php } else if ($order_type === '2' AND ($has_delivery AND $has_collection)) { ?>
									<label class="btn btn-default">
										<input type="radio" name="order_type" value="1">&nbsp;&nbsp;<?php echo $text_delivery; ?>
									</label>
									<label class="btn btn-default active">
										<input type="radio" name="order_type" value="2" checked="checked">&nbsp;&nbsp;<?php echo $text_collection; ?>
									</label>
								<?php } else if ($order_type === '1' AND ($has_delivery AND !$has_collection)) { ?>
									<label class="btn btn-default active">
										<input type="radio" name="order_type" value="1" checked="checked">&nbsp;&nbsp;<?php echo $text_delivery_only; ?>
									</label>
								<?php } else if ($order_type === '2' AND (!$has_delivery AND $has_collection)) { ?>
									<label class="btn btn-default active">
										<input type="radio" name="order_type" value="2" checked="checked">&nbsp;&nbsp;<?php echo $text_collection_only; ?>
									</label>
								<?php } else { ?>
									<label class="btn btn-default">
										<input type="radio" name="order_type" value="0">&nbsp;&nbsp;<?php echo $text_no_types; ?>
									</label>
								<?php } ?>
							</div>
							<div class="delivery-info wrap-horizontal" style="display:none;">
								<dl>
									<dd><span class=""><?php echo $delivery_time; ?></span></dd>
									<dd><span class=""><?php echo $last_order_time; ?></span></dd>
									<dd><span class=""><?php echo $payments; ?></span></dd>
									<?php if (!empty($text_delivery_coverage)) { ?>
										<dd><?php echo $text_delivery_coverage; ?></dd>
									<?php } ?>
								</dl>
								<strong><?php echo $text_delivery_areas; ?></strong>
								<div class="row">
									<div class="col-sm-5"><b>Name</b></div>
									<div class="col-sm-4"><?php echo $text_delivery_charge; ?></div>
									<div class="col-sm-3"><?php echo $text_min_total; ?></div>
									<?php foreach($delivery_areas as $area) { ?>
										<div class="col-sm-5"><?php echo $area['name']; ?></div>
										<div class="col-sm-4"><?php echo $area['charge']; ?></div>
										<div class="col-sm-3"><?php echo $area['min_amount']; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="collection-info wrap-horizontal" style="display:none;">
								<dl>
									<dd><span class=""><?php echo $collection_time; ?></span></dd>
									<dd><span class=""><?php echo $last_order_time; ?></span></dd>
								<dl>
							</div>
						</div>
					</div>
				</div>
			
				<div class="col-xs-6">
					<div id="map" class="">
						<div id="map-holder" style="height:370px;text-align:left;"></div>
					</div>   	
				</div>		
			</div>
		</div>
	</div>
</div>

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
					"<?php echo $map_address; ?><br/>" + 
					"<?php echo $location_telephone; ?>";

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

<script type="text/javascript"><!--
$(document).ready(function() {
	$('input[name="order_type"]').on('change', function() {
		$('.delivery-info, .collection-info').fadeOut();

		if (this.value == '1') {
			$('.delivery-info').fadeIn();
			$('.collection-info').fadeOut();
		} else if (this.value == '2') {
			$('.delivery-info').fadeOut();
			$('.collection-info').fadeIn();
		}
	});
	
	$('input[name="order_type"]:checked').trigger('change');
});
//--></script>
<?php } ?>
<?php echo $footer; ?>