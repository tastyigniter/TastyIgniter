<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
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
<div class="row content">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<?php if (!$local_location) { ?>
	<div class="col-xs-12 wrap-all">
		<div class="row wrap-all text-center" style="display:<?php echo (!$local_location) ? 'block': 'none';?>">
			<form method="POST" action="<?php echo $local_action; ?>">
				<div class="form-group">
					<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
					<div class="col-sm-4 center-block">
						<div class="input-group postcode-group">
							<input type="text" id="postcode" class="form-control text-center postcode-control" name="postcode" value="<?php echo $postcode; ?>">
							<a id="search" class="input-group-addon btn btn-success" onclick="$('form').submit();"><?php echo $text_find; ?></a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<?php } else { ?>
	
	<div class="col-xs-9">
		<div class="row wrap-all" style="display: block;">
			<div class="page-header">
				<h4>
					<?php echo $text_local; ?>&nbsp;&nbsp;&nbsp;
					<a class="label label-success" href="<?php echo $menus_url; ?>"><?php echo $button_view_menu; ?></a>
				</h4>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="">
						<p><?php echo $description; ?></p><br/>
						<span><b><?php echo $text_avail; ?></b>: <?php echo $text_delivery; ?></span><br />
						<span><?php echo $text_open_or_close; ?></span><br />
						<?php if (!empty($text_covered)) { ?>
							<span class="text-danger"><?php echo $text_covered; ?></span><br />
						<?php } ?>
						<span class="distance"><span><?php echo $text_distance; ?>:</span> <?php echo $distance; ?></span><br />		
						<span class="charges"><span><?php echo $text_delivery_charge; ?>:</span> <?php echo $delivery_charge; ?></span><br />
						<span class="review"><span><?php echo $text_reviews; ?>:</span> <?php echo $text_total_review; ?></span>

						<br /><br />
						<address>
							<?php echo $location_address; ?><br/>
							<?php echo $location_telephone; ?>
						</address>
						<?php if ($opening_hours) { ?>
						<br /><br /><strong><?php echo $text_opening_hours; ?></strong>
						<dl class="dl-horizontal opening-hour">
							<?php foreach ($opening_hours as $opening_hour) { ?>
								<dt><?php echo $opening_hour['day']; ?>:</dt>
								<?php if ($opening_hour['open'] === '00:00' OR $opening_hour['close'] === '00:00') { ?>
									<dd><?php echo $text_open; ?><dd>
								<?php } else { ?>
									<dd><?php echo $opening_hour['open']; ?> - <?php echo $opening_hour['close']; ?></dd>
								<?php } ?>
							<?php } ?>
						</dl>
						<?php } ?>
					</div>
				</div>
			
				<div class="col-xs-6">
					<div id="map" class="">
						<div id="map-holder" style="height:370px;text-align:left;"></div>
					</div>   	
				</div>		
			</div>

			<div class="row wrap-all">
				<div class="page-header"><h4><?php echo $text_review; ?></h4></div>
				<?php if ($reviews) { ?>
					<?php foreach ($reviews as $review) { ?>
						<blockquote>
							<ul class="list-inline text-sm">
								<li><b>Quality:</b> <?php echo $review['quality']; ?></li>
								<li><b>Delivery:</b> <?php echo $review['delivery']; ?></li>
								<li><b>Service:</b> <?php echo $review['service']; ?></li>
							</ul>
							<p class="text-sm"><?php echo $review['text']; ?></p>
							<footer>
								<?php echo $review['author']; ?><?php echo $text_from; ?>
								<cite title="Source Title"><?php echo $review['city']; ?></cite><?php echo $text_on; ?>
								<?php echo $review['date']; ?>
							</footer>
						</blockquote>
					<?php } ?>
				<?php } else { ?>
					<p><?php echo $text_empty; ?></p>
				<?php } ?>

				<div class="wrap-horizontal">
					<div class="pagination-box text-right clearfix">
						<?php echo $pagination['links']; ?>
						<div class="pagination-info"><?php echo $pagination['info']; ?></div>
					</div>
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
<?php echo $footer; ?>