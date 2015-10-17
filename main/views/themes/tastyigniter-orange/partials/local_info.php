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

        <div class="col-sm-12">
            <?php if ($has_delivery) { ?>
                <h4 class="wrap-bottom border-bottom"><?php echo lang('text_delivery_areas'); ?></h4>

                <div class="row">
                    <div class="col-sm-5"><b><?php echo lang('column_area_name'); ?></b></div>
                    <div class="col-sm-4"><b><?php echo lang('column_area_charge'); ?></b></div>
                    <div class="col-sm-3"><b><?php echo lang('column_area_min_total'); ?></b></div>
                    <?php if (!empty($delivery_areas)) { ?>
                        <?php foreach($delivery_areas as $area) { ?>
                            <div class="col-sm-12 wrap-none">
                                <div class="col-sm-5"><?php echo $area['name']; ?></div>
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

<div class="col-sm-12 wrap-top">
    <div id="map" class="">
        <div id="map-holder" style="height:370px;text-align:left;"></div>
    </div>
</div>
<script type="text/javascript">//<![CDATA[
    var map = null;
    var geocoder = null;
    var bounds = null;
    var markers = [];
    var infoWindow = null;
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
//]]></script>