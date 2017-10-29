---
title: main::default.contact.text_tab_gallery
layout: default
permalink: /contact
---
<div id="page-content">
    <div class="container">

        <div class="row">
            <div class="">
                <div class="row">
                    <div class="col-md-7 center-block bottom-spacing text-center">
                        <div class="contact-info">
                            <ul>
                                <li><strong><?= $defaultLocal->getName(); ?></strong></li>
                                <li><i class="fa fa-globe"></i><?= $defaultLocal->getAddress(); ?></li>
                                <li><i class="fa fa-phone"></i><?= $defaultLocal->getTelephone(); ?></li>
                            </ul>
                        </div>
                    </div>

                    <div id="contactForm" class="col-md-7 center-block">
                        <h4 class="contact-title"><?= lang('main::default.contact.text_summary'); ?></h4>

                        <?= form_open(current_url(),
                            [
                                'id'   => 'contact-form',
                                'role' => 'form',
                                'method'  => 'POST',
                                'handler' => 'onSubmit',
                            ]
                        ); ?>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <select name="subject" id="subject" class="form-control">
                                        <option value=""><?= lang('main::default.contact.text_select_subject'); ?></option>
                                        <?php foreach ($subjects as $key => $subject) { ?>
                                            <option value="<?= $key; ?>"><?= $subject; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?= form_error('subject', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group">
                                    <input
                                        type="text"
                                        name="email"
                                        id="email"
                                        class="form-control"
                                        value="<?= set_value('email'); ?>"
                                        placeholder="<?= lang('main::default.contact.label_email'); ?>"/>
                                    <?= form_error('email', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        name="full_name"
                                        id="full-name"
                                        class="form-control"
                                        value="<?= set_value('full_name'); ?>"
                                        placeholder="<?= lang('main::default.contact.label_full_name'); ?>"/>
                                    <?= form_error('full_name', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group">
                                    <input
                                        type="text"
                                        name="telephone"
                                        id="telephone"
                                        class="form-control"
                                        value="<?= set_value('telephone'); ?>"
                                        placeholder="<?= lang('main::default.contact.label_telephone'); ?>"/>
                                    <?= form_error('telephone', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea
                                name="comment"
                                id="comment"
                                class="form-control"
                                rows="5"
                                placeholder="<?= lang('main::default.contact.label_comment'); ?>"
                            ><?= set_value('comment'); ?></textarea>
                            <?= form_error('comment', '<span class="text-danger">', '</span>'); ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span><?= $captcha; ?></span>
                                <input
                                    type="text"
                                    name="captcha"
                                    class="form-control"
                                    placeholder="<?= lang('main::default.contact.label_captcha'); ?>"/>
                            </div>
                            <?= form_error('captcha', '<span class="text-danger">', '</span>'); ?>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="buttons">
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-block"
                                    ><?= lang('main::default.contact.button_send'); ?></button>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
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
