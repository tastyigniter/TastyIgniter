<div class="<?php echo ($is_mobile OR $is_checkout) ? '' : 'hidden-xs'; ?>" <?php echo $fixed_cart; ?>>
    <div id="cart-box" class="module-box">
        <div class="panel panel-default panel-cart <?php echo ($is_checkout) ? 'hidden-xs' : ''; ?>">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo lang('text_heading'); ?></h3>
            </div>

            <div class="panel-body">
                <div id="cart-alert" class="cart-alert-wrap">
                    <div class="cart-alert"></div>
                    <?php if (!empty($cart_alert)) { ?>
                        <?php echo $cart_alert; ?>
                    <?php } ?>
                </div>

                <?php if ($has_delivery OR $has_collection) { ?>
                    <div class="location-control text-center text-muted">
                        <div id="my-postcode" style="display:<?php echo (empty($alert_no_postcode)) ? 'block' : 'none'; ?>">
                            <div class="btn-group btn-group-md text-center order-type" data-toggle="buttons">
                                <?php if ($has_delivery) { ?>
                                    <label class="btn <?php echo ($order_type === '1') ? 'btn-default btn-primary active' : 'btn-default'; ?>" data-btn="btn-primary">
                                        <input type="radio" name="order_type" value="1" <?php echo ($order_type === '1') ? 'checked="checked"' : ''; ?>>&nbsp;&nbsp;<strong><?php echo lang('text_delivery'); ?></strong>
                                        <span class="small center-block">
                                            <?php if ($delivery_status === 'open') { ?>
                                                <?php echo sprintf(lang('text_in_minutes'), $delivery_time); ?>
                                            <?php } else if ($delivery_status === 'opening') { ?>
                                                <?php echo sprintf(lang('text_starts'), $delivery_time); ?>
                                            <?php } else { ?>
                                                <?php echo lang('text_is_closed'); ?>
                                            <?php } ?>
                                        </span>
                                    </label>
                                <?php } ?>
                                <?php if ($has_collection) { ?>
                                    <label class="btn <?php echo ($order_type === '2') ? 'btn-default btn-primary active' : 'btn-default'; ?>" data-btn="btn-primary">
                                        <input type="radio" name="order_type" value="2" <?php echo ($order_type === '2') ? 'checked="checked"' : ''; ?>>&nbsp;&nbsp;<strong><?php echo lang('text_collection'); ?></strong>
                                        <span class="small center-block">
                                            <?php if ($collection_status === 'open') { ?>
                                                <?php echo sprintf(lang('text_in_minutes'), $collection_time); ?>
                                            <?php } else if ($collection_status === 'opening') { ?>
                                                <?php echo sprintf(lang('text_starts'), $collection_time); ?>
                                            <?php } else { ?>
                                                <?php echo lang('text_is_closed'); ?>
                                            <?php } ?>
                                        </span>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div id="cart-info">
                    <?php if ($cart_items) {?>
                        <div class="cart-items">
                            <ul>
                                <?php foreach ($cart_items as $cart_item) { ?>
                                    <li>
                                        <a class="cart-btn remove text-muted small" onClick="removeCart('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>', '0');"><i class="fa fa-minus-circle"></i></a>
                                        <a class="name-image" onClick="openMenuOptions('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>');">
                                            <?php if (!empty($cart_item['image'])) { ?>
                                                <img class="image img-responsive img-thumbnail" width="<?php echo $cart_images_w; ?>" height="<?php echo $cart_images_h; ?>" alt="<?php echo $cart_item['name']; ?>" src="<?php echo $cart_item['image']; ?>">
                                            <?php } ?>
                                            <span class="name">
                                                <span class="quantity"><?php echo $cart_item['qty'].lang('text_times'); ?></span>
                                                <?php echo $cart_item['name']; ?>
                                            </span>
                                            <?php if (!empty($cart_item['options'])) { ?>
                                                <span class="options text-muted small"><?php echo $cart_item['options']; ?></span>
                                            <?php } ?>
                                        </a>
                                        <p class="comment-amount">
                                            <span class="amount pull-right"><?php echo $cart_item['sub_total']; ?></span>
                                            <?php if (!empty($cart_item['comment'])) { ?>
                                                <span class="comment text-muted small">[<?php echo $cart_item['comment']; ?>]</span>
                                            <?php } ?>
                                        </p>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="cart-coupon">
                            <div class="input-group">
                                <input type="text" name="coupon_code" class="form-control" value="<?php echo isset($coupon['code']) ? $coupon['code'] : ''; ?>" placeholder="<?php echo lang('text_apply_coupon'); ?>" />
                                <span class="input-group-btn"><a class="btn btn-default" onclick="applyCoupon();" title="<?php echo lang('button_apply_coupon'); ?>"><i class="fa fa-check"></i></a></span>
                            </div>
                        </div>

                        <div class="cart-total">
                            <div class="table-responsive">
                                <table width="100%" height="auto" class="table table-none">
                                    <tbody>
                                        <?php foreach ($cart_totals as $name => $total) { ?>
                                            <?php if (!empty($total)) { ?>
                                                <tr>
                                                    <td><span class="text-muted">
                                                        <?php if ($name === 'order_total') { ?>
                                                            <b><?php echo $total['title']; ?>:</b>
                                                        <?php } else if ($name === 'coupon' AND isset($total['code'])) { ?>
                                                            <?php echo $total['title']; ?>:&nbsp;&nbsp;
                                                            <a class="remove clickable" onclick="clearCoupon('<?php echo $total['code']; ?>');"><span class="fa fa-times"></span></a>
                                                        <?php } else { ?>
                                                            <?php echo $total['title']; ?>:
                                                        <?php } ?>
                                                    </span></td>
                                                    <td class="text-right">
                                                        <?php if ($name === 'coupon') { ?>
                                                            -<?php echo $total['amount']; ?>
                                                        <?php } else if ($name === 'order_total') { ?>
                                                            <b><span class="order-total"><?php echo $total['amount']; ?></span></b>
                                                        <?php } else { ?>
                                                            <?php echo $total['amount']; ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="panel-body"><?php echo lang('text_no_cart_items'); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php if (!empty($button_order)) { ?>
            <div class="cart-buttons wrap-none">
                <div class="center-block">
                    <?php echo $button_order; ?>
                    <?php if (!$is_mobile) { ?>
                        <a class="btn btn-link btn-block visible-xs" href="<?php echo site_url('cart') ?>"><?php echo lang('button_view_cart'); ?></a>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php } ?>
    </div>
</div>
<div id="cart-buttons" class="<?php echo (!$is_mobile AND !$is_checkout) ? 'visible-xs' : 'hide'; ?>">
    <a class="btn btn-default cart-toggle" href="<?php echo site_url('cart') ?>" style="text-overflow:ellipsis; overflow:hidden;">
        <?php echo lang('text_heading'); ?>
        <span class="order-total"><?php echo (!empty($order_total)) ? '&nbsp;&nbsp;-&nbsp;&nbsp;'.$order_total : ''; ?></span>
    </a>
</div>
<?php if (!$is_mobile) { ?>
<div class="cart-alert-wrap cart-alert-affix visible-xs-block"><div class="cart-alert"></div><?php if (!empty($cart_alert)) { echo $cart_alert; } ?></div>
<?php } ?>
<script type="text/javascript"><!--
    var alert_close = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

    var cartHeight = pageHeight-(65/100*pageHeight);

    $(document).on('ready', function() {
        $('.cart-alert-wrap .alert').fadeTo('slow', 0.1).fadeTo('slow', 1.0).delay(5000).slideUp('slow');
        $('#cart-info .cart-items').css({"height" : "auto", "max-height" : cartHeight, "overflow" : "auto", "margin-right" : "-15px", "padding-right" : "5px"});

        $(window).bind("load resize", function() {
            var sideBarWidth = $('#content-right .side-bar').width();
            $('#cart-box-affix').css('width', sideBarWidth);
        });
    });

    $(document).on('change', 'input[name="order_type"]', function() {
        if (typeof this.value !== 'undefined') {
            var order_type = this.value;

            $.ajax({
                url: js_site_url('cart_module/cart_module/order_type'),
                type: 'post',
                data: 'order_type=' + order_type,
                dataType: 'json',
                success: function (json) {
                    if (json['redirect'] && json['order_type'] == order_type) {
                        window.location.href = json['redirect'];
                    }
                }
            });
        }
    });

    function addToCart(menu_id, quantity) {
        if ($('#menu-options' + menu_id).length) {
            var data = $('#menu-options' + menu_id + ' input:checked, #menu-options' + menu_id + ' input[type="hidden"], #menu-options' + menu_id + ' select, #menu-options' + menu_id + ' textarea, #menu-options' + menu_id + '  input[type="text"]');
        } else {
            var data = 'menu_id=' + menu_id + '&quantity=' + quantity;
        }

        $('#menu'+menu_id+ ' .add_cart').removeClass('failed');
        $('#menu'+menu_id+ ' .add_cart').removeClass('added');
        if (!$('#menu'+menu_id+ ' .add_cart').hasClass('loading')) {
            $('#menu'+menu_id+ ' .add_cart').addClass('loading');
        }

        $.ajax({
            url: js_site_url('cart_module/cart_module/add'),
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(json) {
                $('#menu'+menu_id+ ' .add_cart').removeClass('loading');
                $('#menu'+menu_id+ ' .add_cart').removeClass('failed');
                $('#menu'+menu_id+ ' .add_cart').removeClass('added');

                if (json['option_error']) {
                    $('#cart-options-alert .alert').remove();

                    $('#cart-options-alert').append('<div class="alert" style="display: none;">' + alert_close + json['option_error'] + '</div>');
                    $('#cart-options-alert .alert').fadeIn('slow');

                    $('#menu' + menu_id + ' .add_cart').addClass('failed');
                } else {
                    $('#optionsModal').modal('hide');

                    if (json['error']) {
                        $('#menu' + menu_id + ' .add_cart').addClass('failed');
                    }

                    if (json['success']) {
                        $('#menu' + menu_id + ' .add_cart').addClass('added');
                    }

                    updateCartBox(json);
                }
            }
        });
    }

    function openMenuOptions(menu_id, row_id) {
        if (menu_id) {
            var row_id = (row_id) ? row_id : '';

            $.ajax({
                url: js_site_url('cart_module/cart_module/options?menu_id=' + menu_id + '&row_id=' + row_id),
                dataType: 'html',
                success: function(html) {
                    $('#optionsModal').remove();
                    $('body').append('<div id="optionsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>');
                    $('#optionsModal').html(html);

                    $('#optionsModal').modal();
                    $('#optionsModal').on('hidden.bs.modal', function(e) {
                        $('#optionsModal').remove();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }

    function removeCart(menu_id, row_id, quantity) {
        $.ajax({
            url: js_site_url('cart_module/cart_module/remove'),
            type: 'post',
            data: 'menu_id' + menu_id + '&row_id=' + row_id + '&quantity=' + quantity,
            dataType: 'json',
            success: function(json) {
                updateCartBox(json)
            }
        });
    }

    function applyCoupon() {
        var coupon_code = $('#cart-box input[name="coupon_code"]').val();
        $.ajax({
            url: js_site_url('cart_module/cart_module/coupon'),
            type: 'post',
            data: 'action=add&code=' + coupon_code,
            dataType: 'json',
            success: function(json) {
                updateCartBox(json)
            }
        });
    }

    function clearCoupon(coupon_code) {
        $('input[name=\'coupon\']').attr('value', '');

        $.ajax({
            url: js_site_url('cart_module/cart_module/coupon'),
            type: 'post',
            data: 'action=remove&code=' + coupon_code,
            dataType: 'json',
            success: function(json) {
                updateCartBox(json)
            }
        });
    }

    function updateCartBox(json) {
        var alert_message = '';

        if (json['redirect']) {
            window.location.href = json['redirect'];
        }

        if (json['error']) {
            alert_message = '<div class="alert">' + alert_close + json['error'] + '</div>';
            updateCartAlert(alert_message);
        } else {
            if (json['success']) {
                alert_message = '<div class="alert">' + alert_close + json['success'] + '</div>';
            }

            $('#cart-box').load(js_site_url('cart_module/cart_module #cart-box > *'), function(response) {
                updateCartAlert(alert_message);
            });
        }
    }

    function updateCartAlert(alert_message) {
        if (alert_message != '') {
            $('.cart-alert-wrap .alert, .cart-alert-wrap .cart-alert').empty();
            $('.cart-alert-wrap .cart-alert').append(alert_message);
            $('.cart-alert-wrap .alert').slideDown('slow').fadeTo('slow', 0.1).fadeTo('slow', 1.0).delay(5000).slideUp('slow');
        }

        if ($('#cart-info .order-total').length > 0) {
            $('#cart-box-affix .navbar-toggle .order-total').html(" - " + $('#cart-info .order-total').html());
        }

        $('#cart-info .cart-items').css({"height" : "auto", "max-height" : cartHeight, "overflow" : "auto", "margin-right" : "-15px", "padding-right" : "5px"});
    }
    //--></script>