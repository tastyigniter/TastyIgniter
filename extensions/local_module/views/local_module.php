<div id="local-box" <?php echo ($location_search === TRUE) ? 'class="local-box-fluid"' : ''; ?>>
    <div <?php echo ($module_position === 'top') ? 'class="container"' : 'class="container-fluid"'; ?>>
        <div id="local-alert" class="col-md-12" style="display: <?php echo ($local_alert) ? 'block' : 'none'; ?>">
            <div class="local-alert">
                <?php echo $local_alert; ?>
            </div>
        </div>

        <?php if ($location_search === TRUE) { ?>
            <div id="local-search" class="col-md-12 text-center">
                <div class="panel panel-local">
                    <div class="panel-body">
                        <h2><?php echo lang('text_order_summary'); ?></h2>
                        <span class="search-label sr-only"><?php echo lang('label_search_query'); ?></span>
                        <form id="location-form" method="POST" action="<?php echo $local_action; ?>" role="form">
                            <div class="col-xs-12 col-sm-6 col-md-4 center-block">
                                <div class="input-group postcode-group">
                                    <input type="text" id="search-query" class="form-control text-center postcode-control input-lg" name="search_query" placeholder="<?php echo lang('label_search_query'); ?>" value="<?php echo $search_query; ?>">
                                    <a id="search" class="input-group-addon btn btn-primary" onclick="searchLocal()"><?php echo lang('text_find'); ?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } else if ($rsegment !== 'locations') { ?>
            <div id="local-info" class="col-md-12" style="display: <?php echo ($local_info) ? 'block' : 'none'; ?>">
                <div class="panel panel-local display-local">
                    <div class="panel-heading">
                        <div class="row local-change" style="display: <?php echo (!empty($search_query)) ? 'block' : 'none'; ?>">
                            <div class="col-xs-12 col-sm-7">
                                <?php echo sprintf(lang('text_location_summary'), $location_name, $search_query); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a onclick="toggleLocalSearch();" class="clickable btn-link" title=""><?php echo lang('button_change_location'); ?></a>
                            </div>

                            <?php if (!in_array($rsegment, array('local', 'locations'))) { ?>
                                <div class="col-xs-12 col-sm-5 text-right">
                                    <a class="btn btn-primary btn-menus" href="<?php echo site_url('local?location_id='.$location_id).'/#local-menus'; ?>"><i class="fa fa-cutlery"></i>
                                        <span>&nbsp;&nbsp;<?php echo lang('text_goto_menus'); ?></span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="row local-search bg-warning" style="display: <?php echo (!empty($search_query)) ? 'none' : 'block'; ?>">
                            <div class="col-xs-12 col-sm-6 center-block">
                                <a class="close-search clickable" onclick="toggleLocalSearch();">&times;</a>
                                <div class="postcode-group text-center">
                                    <?php echo lang('text_enter_location'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="input-group">
                                        <input type="text" id="search-query" class="form-control text-center postcode-control input-xs" name="search_query" placeholder="<?php echo lang('label_search_query'); ?>" value="<?php echo $search_query; ?>">
                                        <a id="search" class="input-group-addon btn btn-primary" onclick="searchLocal();"><?php echo lang('button_search_location'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="box-one col-sm-5 col-md-5">
                            <img class="img-responsive pull-left" src="<?php echo $location_image; ?>">
                            <dl>
                                <dd><h4><?php echo $location_name; ?></h4></dd>
                                <dd>
                                    <div class="rating rating-sm">
                                        <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star-half-o"></span><span class="fa fa-star-o"></span>
                                        <span class="small"><?php echo $text_total_review; ?></span>
                                    </div>
                                </dd>
                                <dd><span class="text-muted"><?php echo $location_address; ?></span></dd>
                            </dl>
                        </div>
                        <div class="box-two col-sm-4 col-md-4">
                            <dl>
                                <?php if ($opening_status === '1') { ?>
                                    <dt class="text-muted"><?php echo ($is_opened) ? lang('text_is_opened') : lang('text_is_closed'); ?></dt>
                                    <dd class="">
                                        <?php if (!empty($opening_type) AND $opening_type == '24_7') { ?>
                                            <span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo lang('text_24_7_hour'); ?></span>
                                        <?php } else if (!empty($opening_time) AND !empty($closing_time)) { ?>
                                            <span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo $opening_time; ?> - <?php echo $closing_time; ?></span>
                                        <?php } ?>
                                    </dd>
                                <?php } else { ?>
                                    <dt class="text-muted"><?php echo lang('text_is_temp_closed'); ?></dt>
                                <?php } ?>
                                <dd><?php echo sprintf(lang('text_delivery_time_info'), $delivery_time); ?></dd>
                                <dd><?php echo sprintf(lang('text_collection_time_info'), $collection_time); ?></dd>
                            </dl>
                        </div>
                        <div class="box-three col-sm-3 col-md-3">
                            <dl>
                                <dd><b><?php echo lang('text_offer'); ?>:</b> <?php echo $text_service_offered; ?></dd>
                                <dd><?php echo $text_delivery_charge; ?></dd>
                                <dd><b><?php echo lang('text_min_total'); ?>:</b> <?php echo $min_total; ?></dd>
                            </dl>
                       </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
<script type="text/javascript"><!--
    $(document).ready(function() {
        $('.review-toggle').on('click', function() {
            $('a[href="#reviews"]').tab('show');
        });
    });

    function toggleLocalSearch() {
        if ($('.panel-local .panel-heading .local-search').is(":visible")) {
            $('.panel-local .panel-heading .local-search').fadeOut('fast');
            $('.panel-local .panel-heading .local-change').fadeIn('fast');
        } else {
            $('.panel-local .panel-heading .local-search').fadeIn('fast');
            $('.panel-local .panel-heading .local-change').fadeOut('fast');
        }
    }

    $(document).on('change', 'input[name="order_type"]', function() {
        $.ajax({
            url: js_site_url('local_module/local_module/order_type'),
            type: 'post',
            data: 'order_type=' + this.value,
            dataType: 'json',
            success: function(json) {
                $('.delivery-info, .collection-info').fadeOut();

                if (this.value == '1') {
                    $('.delivery-info').fadeIn();
                    $('.collection-info').fadeOut();
                } else {
                    $('.delivery-info').fadeOut();
                    $('.collection-info').fadeIn();
                }

                updateLocalBox(json);
            }
        });
    });

    function searchLocal() {
        var search_query = $('input[name=\'search_query\']').val();

        $.ajax({
            url: js_site_url('local_module/local_module/search'),
            type: 'POST',
            data: 'search_query=' + search_query,
            dataType: 'json',
            success: function(json) {
                updateLocalBox(json);
            }
        });
    }

    function updateLocalBox(json) {
        var alert_close = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        var local_alert = $('#local-alert .local-alert');
        var alert_message = '';

        if (json['redirect']) {
            window.location.href = json['redirect'];
        }

        if (json['error']) {
            alert_message = '<div class="alert">' + alert_close + json['error'] + '</div>';
        }

        if (json['success']) {
            alert_message = '<div class="alert">' + alert_close + json['success'] + '</div>';
        }

        $('#cart-box').load(js_site_url('cart_module/cart_module #cart-box > *'), function(response) {
            if (alert_message != '') {
                local_alert.empty();
                local_alert.append(alert_message);
                $('#local-alert').fadeIn('slow').fadeTo('fast', 0.5).fadeTo('fast', 1.0);
                $('html, body').animate({scrollTop: 0}, 300);
            }
        });
    }
//--></script>