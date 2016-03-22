<div id="local-box" <?php echo ($location_search === TRUE) ? 'class="local-box-fluid"' : ''; ?>>
    <div class="container">
        <?php if ($location_search === TRUE) { ?>
            <div id="local-search" class="col-md-12 text-center">
                <div class="panel panel-local">
                    <div class="panel-body">
                        <h2><?php echo (isset($local_lang['text_order_summary'])) ? $local_lang['text_order_summary'] : lang('text_order_summary'); ?></h2>
                        <span class="search-label sr-only"><?php echo lang('label_search_query'); ?></span>
                        <div class="col-xs-12 col-sm-6 col-md-5 center-block">
                            <?php if ($location_search_mode === 'multi') { ?>
                                <form id="location-form" method="POST" action="<?php echo $local_action; ?>" role="form">
                                    <div class="input-group postcode-group">
                                        <input type="text" id="search-query" class="form-control text-center postcode-control input-lg" name="search_query" placeholder="<?php echo lang('label_search_query'); ?>" value="<?php echo $search_query; ?>">
                                        <a id="search" class="input-group-addon btn btn-primary" onclick="searchLocal()"><?php echo (isset($local_lang['text_find'])) ? $local_lang['text_find'] : lang('text_find'); ?></a>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <a class="btn btn-block btn-primary" href="<?php echo $single_location_url; ?>"><?php echo (isset($local_lang['text_find'])) ? $local_lang['text_find'] : lang('text_find'); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="local-alert" class="col-xs-12 col-sm-6 center-block">
                <div class="local-alert"></div>
            </div>
        <?php } else if ($rsegment !== 'locations') { ?>
            <div id="local-alert" class="col-sm-12">
                <div class="local-alert"></div>
                <?php if (!empty($local_alert)) { ?>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div class="alert">
                        <?php echo $local_alert; ?>
                    </div>
                <?php } ?>
            </div>


            <div id="local-info" class="col-md-12" style="display: <?php echo ($local_info) ? 'block' : 'none'; ?>">
                <div class="panel panel-local display-local">
                    <?php if ($location_search_mode === 'multi') { ?>
                        <div class="panel-heading">
                            <div class="row local-change" style="display: <?php echo (!empty($search_query) OR $location_order !== '1') ? 'block' : 'none'; ?>">
                                <div class="col-xs-12 col-sm-7">
                                    <?php $text_location_summary = (isset($local_lang['text_location_summary'])) ? $local_lang['text_location_summary'] : lang('text_location_summary'); ?>
                                    <?php $text_search_query = (empty($search_query)) ? '' : lang('text_at').$search_query; ?>
                                    <?php echo sprintf($text_location_summary, $location_name, $text_search_query); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="toggleLocalSearch();" class="clickable btn-link" title=""><?php echo lang('button_change_location'); ?></a>
                                </div>

                                <?php if (!in_array($rsegment, array('local', 'locations'))) { ?>
                                    <div class="col-xs-12 col-sm-5 text-right">
                                        <a class="btn btn-primary btn-menus" href="<?php echo site_url('local?location_id='.$location_id).'/#local-menus'; ?>"><i class="fa fa-cutlery"></i>
                                            <span>&nbsp;&nbsp;<?php echo (isset($local_lang['text_goto_menus'])) ? $local_lang['text_goto_menus'] : lang('text_goto_menus'); ?></span>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="row local-search bg-warning" style="display: <?php echo (!empty($search_query) OR $location_order !== '1') ? 'none' : 'block'; ?>">
                                <a class="close-search clickable" onclick="toggleLocalSearch();">&times;</a>
                                <div class="col-xs-12 col-sm-6 center-block">
                                    <div class="postcode-group text-center">
                                        <?php echo (isset($local_lang['text_enter_location'])) ? $local_lang['text_enter_location'] : lang('text_enter_location'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="input-group">
                                            <input type="text" id="search-query" class="form-control text-center postcode-control input-xs" name="search_query" placeholder="<?php echo lang('label_search_query'); ?>" value="<?php echo $search_query; ?>">
                                            <a id="search" class="input-group-addon btn btn-primary" onclick="searchLocal();"><?php echo lang('button_search_location'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="panel-body">
                        <div class="row boxes">
                            <div class="box-one col-xs-12 col-sm-5 col-md-5">
                                <img class="img-responsive pull-left" src="<?php echo $location_image; ?>">
                                <dl>
                                    <dd><h4><?php echo $location_name; ?></h4></dd>
                                    <?php if (config_item('allow_reviews') !== '1') { ?>
                                        <dd>
                                            <div class="rating rating-sm">
                                                <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star-half-o"></span><span class="fa fa-star-o"></span>
                                                <span class="small"><?php echo $text_total_review; ?></span>
                                            </div>
                                        </dd>
                                    <?php } ?>
                                    <dd><span class="text-muted"><?php echo $location_address; ?></span></dd>
                                </dl>
                            </div>
                            <div class="clearfix visible-xs"></div>
                            <div class="box-two col-sm-4 col-md-4">
                                <dl>
                                    <?php if ($opening_status === '1') { ?>
                                        <?php $text_is_opened = (isset($local_lang['text_is_opened'])) ? $local_lang['text_is_opened'] : lang('text_is_opened'); ?>
                                        <?php $text_is_closed = (isset($local_lang['text_is_closed'])) ? $local_lang['text_is_closed'] : lang('text_is_closed'); ?>
                                        <dt class="text-muted"><?php echo ($is_opened) ? $text_is_opened : $text_is_closed; ?></dt>
                                        <dd class="hidden-xs">
                                            <?php if (!empty($opening_type) AND $opening_type == '24_7') { ?>
                                                <span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo (isset($local_lang['text_24_7_hour'])) ? $local_lang['text_24_7_hour'] : lang('text_24_7_hour'); ?></span>
                                            <?php } else if (!empty($opening_time) AND !empty($closing_time)) { ?>
                                                <span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo $opening_time; ?> - <?php echo $closing_time; ?></span>
                                            <?php } ?>
                                        </dd>
                                    <?php } else { ?>
                                        <dt class="text-muted"><?php echo (isset($local_lang['text_is_temp_closed'])) ? $local_lang['text_is_temp_closed'] : lang('text_is_temp_closed'); ?></dt>
                                    <?php } ?>
                                    <?php if ($has_delivery) { ?>
                                        <?php $text_delivery_time_info = (isset($local_lang['text_delivery_time_info'])) ? $local_lang['text_delivery_time_info'] : lang('text_delivery_time_info'); ?>
                                        <dd><?php echo sprintf($text_delivery_time_info, $delivery_time); ?></dd>
                                    <?php } ?>

                                    <?php if ($has_collection) { ?>
                                        <?php $text_collection_time_info = (isset($local_lang['text_collection_time_info'])) ? $local_lang['text_collection_time_info'] : lang('text_collection_time_info'); ?>
                                        <dd><?php echo sprintf($text_collection_time_info, $collection_time); ?></dd>
                                    <?php } ?>
                                </dl>
                            </div>
                            <div class="box-three col-sm-3 col-md-3">
                                <dl>
                                    <dd><b><?php echo (isset($local_lang['text_offer'])) ? $local_lang['text_offer'] : lang('text_offer'); ?>:</b> <?php echo $text_service_offered; ?></dd>
                                    <?php if ($has_delivery) { ?>
                                        <dd class="hidden-xs"><?php echo $text_delivery_charge; ?></dd>
                                    <?php } ?>
                                    <dd class="hidden-xs"><b><?php echo (isset($local_lang['text_min_total'])) ? $local_lang['text_min_total'] : lang('text_min_total'); ?>:</b> <?php echo $min_total; ?></dd>
                                </dl>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
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

        if ($('#cart-box').is(':visible')) {
            $('#cart-box').load(js_site_url('cart_module/cart_module #cart-box > *'), function (response) {
                if (alert_message != '') {
                    local_alert.empty();
                    local_alert.append(alert_message);
                    $('#local-alert').fadeIn('slow').fadeTo('fast', 0.5).fadeTo('fast', 1.0);
                    $('html, body').animate({scrollTop: 0}, 300);
                }
            });
        } else {
            if (alert_message != '') {
                local_alert.empty();
                local_alert.append(alert_message);
                $('#local-alert').fadeIn('slow').fadeTo('fast', 0.5).fadeTo('fast', 1.0);
                $('html, body').animate({scrollTop: 0}, 300);
            }
        }
    }
//--></script>
</div>
