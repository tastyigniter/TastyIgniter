<div id="cart-box" class="module-box">
	<div class="panel panel-default panel-cart">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('text_heading'); ?></h3>
		</div>

		<div class="panel-body">
			<div id="cart-alert">
                <div class="cart-alert"></div>
                <?php if (!empty($cart_alert)) { ?>
                    <?php echo $cart_alert; ?>
				<?php } ?>
			</div>

			<div class="location-control text-center text-muted">
				<div id="my-postcode" class="wrap-bottom" style="display:<?php echo (empty($alert_no_postcode)) ? 'block' : 'none'; ?>">
					<div class="btn-group btn-group-md order-type" data-toggle="buttons">
                        <?php if ($has_delivery) { ?>
                        <label class="btn <?php echo ($order_type === '1') ? 'btn-primary active' : 'btn-default'; ?>" data-btn="btn-primary">
                            <input type="radio" name="order_type" value="1" <?php echo ($order_type === '1') ? 'checked="checked"' : ''; ?>>&nbsp;&nbsp;<?php echo lang('text_delivery'); ?>
                            <span class="small center-block"><?php echo $delivery_time.' '.lang('text_min'); ?></span>
                        </label>
                        <?php } ?>
                        <?php if ($has_collection) { ?>
                        <label class="btn <?php echo ($order_type === '2') ? 'btn-primary active' : 'btn-default'; ?>" data-btn="btn-primary">
                            <input type="radio" name="order_type" value="2" <?php echo ($order_type === '2') ? 'checked="checked"' : ''; ?>>&nbsp;&nbsp;<?php echo lang('text_collection'); ?>
                            <span class="small center-block"><?php echo $collection_time.' '.lang('text_min'); ?></span>
                        </label>
                        <?php } ?>
                    </div>
				</div>
			</div>

			<div id="cart-info">
				<?php if ($cart_items) {?>
					<div class="cart-items">
						<ul>
							<?php foreach ($cart_items as $cart_item) { ?>
								<li>
									<a class="cart-btn remove" onClick="removeCart('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>', '0');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-trash"></i></a>
									<a class="name-image" onClick="openMenuOptions('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>');">
										<?php if (!empty($cart_item['image'])) { ?>
											<img class="image img-responsive img-thumbnail" width="<?php echo $cart_images_w; ?>" height="<?php echo $cart_images_h; ?>" alt="<?php echo $cart_item['name']; ?>" src="<?php echo $cart_item['image']; ?>">
										<?php } ?>
										<span class="name">
                                            <span class="quantity small"><?php echo $cart_item['qty'].lang('text_times'); ?></span>
                                            <?php echo $cart_item['name']; ?>
                                        </span>
									</a>
                                    <?php if (!empty($cart_item['options'])) { ?>
                                        <span class="options small"><?php echo $cart_item['options']; ?></span>
                                    <?php } ?>
                                    <?php if (!empty($cart_item['comment'])) { ?>
                                        <span class="text-muted comment small">[<?php echo $cart_item['comment']; ?>]</span>
                                    <?php } ?>
                                    <p class="amount"><?php echo $cart_item['sub_total']; ?></p>
								</li>
							<?php } ?>
						</ul>
					</div>

					<div class="cart-coupon">
						<div class="table-responsive">
							<table width="100%" height="auto" class="table table-none">
								<tbody>
									<tr>
										<td class="text-right"><input type="text" name="coupon_code" class="form-control pull-right" value="<?php echo isset($coupon['code']) ? $coupon['code'] : ''; ?>" placeholder="<?php echo lang('text_apply_coupon'); ?>" /></td>
										<td><a class="btn btn-default" onclick="applyCoupon();"><?php echo lang('button_apply_coupon'); ?></a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="cart-total">
						<div class="table-responsive">
							<table width="100%" height="auto" class="table table-none">
								<tbody>
									<?php if (!empty($sub_total)) { ?>
                                        <tr>
                                            <td><b><?php echo lang('text_sub_total'); ?>:</b></td>
                                            <td class="text-right"><?php echo $sub_total; ?></td>
                                        </tr>
									<?php } ?>
									<?php if (!empty($coupon) AND isset($coupon['code']) AND isset($coupon['discount'])) { ?>
                                        <tr>
                                            <td><b><?php echo lang('text_coupon'); ?>:</b></td>
                                            <td class="text-right"><a class="remove clickable" onclick="clearCoupon('<?php echo $coupon['code']; ?>');"><span class="fa fa-times"></span></a>
                                            &nbsp;&nbsp;-<?php echo $coupon['discount']; ?></td>
                                        </tr>
									<?php } ?>
									<?php if (!empty($delivery)) { ?>
                                        <tr>
                                            <td><b><?php echo lang('text_delivery'); ?>:</b></td>
                                            <td class="text-right"><?php echo $delivery; ?></td>
                                        </tr>
									<?php } ?>
									<?php if (!empty($taxes) AND isset($taxes['title']) AND isset($taxes['amount'])) { ?>
                                        <tr>
                                            <td><b><?php echo $taxes['title']; ?>:</b></td>
                                            <td class="text-right"><?php echo $taxes['amount']; ?></td>
                                        </tr>
									<?php } ?>
                                        <tr>
                                            <td><b><?php echo lang('text_order_total'); ?>:</b></td>
                                            <td class="text-right"><span class="order-total"><?php echo $order_total; ?></span></td>
									    </tr>
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
</div>

<?php if (!empty($button_order)) { ?>
    <div class="buttons wrap-none">
        <div class="center-block">
            <?php echo $button_order; ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php } ?>
<script type="text/javascript"><!--
    var alert_close = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

    $(document).on('change', 'input[name="order_type"]', function() {
        $.ajax({
            url: js_site_url('cart_module/cart_module/order_type'),
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

                updateCartBox(json);
            }
        });
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

                if (json['options_error']) {
                    $('#cart-options-alert .alert').remove();

                    $('#cart-options-alert').append('<div class="alert" style="display: none;">' + alert_close + json['options_error'] + '</div>');
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
        }

        if (json['success']) {
            alert_message = '<div class="alert">' + alert_close + json['success'] + '</div>';
        }

        $('#cart-box').load(js_site_url('cart_module/cart_module #cart-box > *'), function(response) {
            if (alert_message != '') {
                $('#cart-alert .cart-alert').empty();
                $('#cart-alert .cart-alert').append(alert_message);
                $('#cart-alert .alert').fadeIn('slow').fadeTo('fast', 0.5).fadeTo('fast', 1.0);
            }
        });
    }
    //--></script>