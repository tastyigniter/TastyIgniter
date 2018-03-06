---
title: main::default.contact.text_tab_gallery
layout: default
permalink: /contact

'[contact]':
---
<div id="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <div class="contact-info">
                        <ul>
                            <li><strong><?= $contact->location->getName(); ?></strong></li>
                            <li><i class="fa fa-globe"></i><?= format_address($contact->location->getAddress()); ?></li>
                            <li><i class="fa fa-phone"></i><?= $contact->location->getTelephone(); ?></li>
                        </ul>
                    </div>

                    <h4 class="contact-title">
                        <?= lang('sampoyigi.frontend::default.contact.text_summary'); ?>
                    </h4>

                    <?= component('contact'); ?>
                </div>

                <div class="heading-section">
                    <h3><?= lang('main::default.contact.text_find_us'); ?></h3>
                    <span class="under-heading"></span>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="map" class="">
                            <div id="map-holder" style="height:370px;text-align:left;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">//<![CDATA[
    //        var map;
    //        var geocoder = null;
    //        var bounds = null;
    //        var markers = [];
    //        var infoWindow = null;
    //        var local_name = "<?//= $location_name; ?>//";
    //        var latlng = new google.maps.LatLng(
    //            parseFloat("<?//= $location_lat; ?>//"),
    //            parseFloat("<?//= $location_lng; ?>//")
    //        );
    //
    //        function initializeMap() {
    //            var html = "<b>" + local_name + "</b> <br/>" +
    //                "<?//= $location_address; ?>//<br/>" +
    //                "<?//= $location_telephone; ?>//";
    //
    //            var mapOptions = {
    //                scrollwheel: false,
    //                center: latlng,
    //                zoom: 14,
    //                mapTypeId: google.maps.MapTypeId.ROADMAP
    //            };
    //
    //            var map = new google.maps.Map(document.getElementById('map-holder'), mapOptions);
    //
    //            var infowindow = new google.maps.InfoWindow({
    //                content: html
    //            });
    //
    //            var marker = new google.maps.Marker({
    //                position: latlng,
    //                map: map,
    //                title: local_name
    //            });
    //
    //            google.maps.event.addListener(marker, 'click', function() {
    //                infowindow.open(map,marker);
    //            });
    //        }
    //
    //        google.maps.event.addDomListener(window, 'load', initializeMap);
    //]]></script>
