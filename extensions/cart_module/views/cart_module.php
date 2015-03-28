<div id="cart-box" class="module-box">
	<!--<?php if (!empty($text_closed)) { ?>
		<div class="text-danger text-center well"><b><?php echo $text_closed; ?></b></div>
	<?php } ?>-->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $text_my_order; ?></h3>
		</div>

		<div class="panel-body">
			<div id="cart-alert">
				<?php if ($cart_alert) { ?>
				<div class="alert alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $cart_alert; ?>
				</div>
				<?php } ?>
			</div>

			<div class="location-control text-center text-muted">
				<div id="search-query" class="wrap-bottom" style="display:<?php echo (!empty($alert_no_postcode)) ? 'block' : 'none'; ?>">
					<div class="input-group input-group-sm postcode-group">
						<input type="text" id="postcode" class="form-control text-center postcode-control" name="postcode" placeholder="My Postcode" value="<?php echo $search_query; ?>">
						<a class="input-group-addon btn btn-success" onclick="searchLocal();"><?php echo $text_find; ?></a>
					</div>
				</div>

				<div id="my-postcode" class="wrap-bottom" style="display:<?php echo (empty($alert_no_postcode)) ? 'block' : 'none'; ?>">
					<div class="wrap-bottom">
						<span class="small pull-left"><?php echo $text_search_query; ?>: <b><?php echo $search_query; ?></b></span>
						<a class="small pull-right" onclick="clearLocal();"><?php echo $text_change_location; ?></a><br />
					</div>

					<div class="btn-group btn-group-md order-type" data-toggle="buttons">
						<?php if ($order_type === '1') { ?>
							<label class="btn btn-default active">
								<input type="radio" name="order_type" value="1" checked="checked">&nbsp;&nbsp;<?php echo $text_delivery; ?>
							</label>
							<label class="btn btn-default">
								<input type="radio" name="order_type" value="2">&nbsp;&nbsp;<?php echo $text_collection; ?>
							</label>
						<?php } else if ($order_type === '2') { ?>
							<label class="btn btn-default">
								<input type="radio" name="order_type" value="1">&nbsp;&nbsp;<?php echo $text_delivery; ?>
							</label>
							<label class="btn btn-default active">
								<input type="radio" name="order_type" value="2" checked="checked">&nbsp;&nbsp;<?php echo $text_collection; ?>
							</label>
						<?php } else { ?>
							<label class="btn btn-default">
								<input type="radio" name="order_type" value="1">&nbsp;&nbsp;<?php echo $text_delivery; ?>
							</label>
							<label class="btn btn-default">
								<input type="radio" name="order_type" value="2">&nbsp;&nbsp;<?php echo $text_collection; ?>
							</label>
						<?php } ?>
					</div>

					<div class="delivery-info text-center" style="display:<?php echo ($order_type === '1') ? 'block' : 'none'; ?>">
						<span class="small"><?php echo $delivery_time; ?></span><br />
						<span class="small"><?php echo $delivery_charge; ?></span><br />
						<span class="small"><?php echo $text_min_total; ?>: <?php echo $min_total; ?></span><br />
					</div>
					<div class="collection-info text-center" style="display:<?php echo ($order_type === '2') ? 'block' : 'none'; ?>;">
						<span class="small"><?php echo $collection_time; ?></span><br />
					</div>
				</div>
			</div>

			<div id="cart-info">
				<?php if ($cart_items) {?>
					<div class="cart-items">
						<ul>
							<?php foreach ($cart_items as $cart_item) { ?>
								<li>
									<a class="remove" onClick="removeCart('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>', '0');"><i class="fa fa-trash"></i></a>
									<a class="name-image" onClick="openMenuOptions('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>');">
										<?php if ($show_cart_image) { ?>
											<img class="image img-responsive img-thumbnail" width="<?php echo $cart_images_w; ?>" height="<?php echo $cart_images_h; ?>" alt="<?php echo $cart_item['name']; ?>" src="<?php echo $cart_item['image']; ?>">
										<?php } ?>
										<span class="name"><?php echo $cart_item['name']; ?></a>
										<?php if (!empty($cart_item['options'])) { ?>
											<span class="options small">+ <?php echo $cart_item['options']; ?></span>
										<?php } ?>
									</a>
									<span class="quantity small">
										<?php echo $cart_item['qty']; ?> ×
										<span class="amount"><?php echo $cart_item['sub_total']; ?></span>
									</span>
								</li>
							<?php } ?>
						</ul>
					</div>

					<div class="cart-coupon">
						<div class="table-responsive">
							<table width="100%" height="auto" class="table table-none">
								<tbody>
									<tr>
										<td class="text-right"><input type="text" name="coupon_code" class="form-control pull-right" value="<?php echo isset($coupon['code']) ? $coupon['code'] : ''; ?>" placeholder="<?php echo $text_apply_coupon; ?>" /></td>
										<td><a class="btn btn-default" onclick="applyCoupon();"><?php echo $button_coupon; ?></a></td>
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
										<td><b><?php echo $text_sub_total; ?>:</b></td>
										<td class="text-right"><?php echo $sub_total; ?></td>
									</tr>
									<?php } ?>
									<?php if (!empty($coupon) AND isset($coupon['code']) AND isset($coupon['discount'])) { ?>
									<tr>
										<td><b><?php echo $text_coupon; ?>:</b></td>
										<td class="text-right"><a class="remove" onclick="clearCoupon('<?php echo $coupon['code']; ?>');"><span class="fa fa-times"></span></a>
										&nbsp;&nbsp;-<?php echo $coupon['discount']; ?></td>
									</tr>
									<?php } ?>
									<?php if (!empty($delivery)) { ?>
									<tr>
										<td><b><?php echo $text_delivery; ?>:</b></td>
										<td class="text-right"><?php echo $delivery; ?></td>
									</tr>
									<?php } ?>
									<tr>
										<td><b><?php echo $text_order_total; ?>:</b></td>
										<td class="text-right"><span class="order-total"><?php echo $order_total; ?></span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				<?php } else { ?>
					<div class="panel-body"><?php echo $text_no_cart_items; ?></div>
				<?php } ?>
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
</div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/js/fancybox/jquery.fancybox.css"); ?>">
<script src="<?php echo base_url("assets/js/fancybox/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
var alert_close = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

function searchLocal() {
	var postcode = $('input[name=\'postcode\']').val();

	$.ajax({
		url: js_site_url('local_module/local_module/search'),
		type: 'post',
		data: 'postcode=' + postcode,
		dataType: 'json',
		success: function(json) {
			$('#cart-alert .alert').remove();

			if(json['redirect']) {
				window.location.href = json['redirect'];
			}

			if (json['error']) {
				$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['error'] + '</div>');
				$('.alert').fadeIn('slow');
			} else {
				$('#cart-box > .panel > .panel-body').load(js_site_url('cart_module/cart_module #cart-box > .panel > .panel-body > *'));
				$('#local-info').load(js_site_url('local_module/local_module #local-info > *'));
				$('#local-info').fadeIn('slow');

				$('input[name="order_type"]:checked').trigger('change');
			}
		}
	});
}

function clearLocal() {
	$('#search-query').show();
	$('#my-postcode').hide();
}

$(document).on('change', 'input[name="order_type"]', function() {
	var order_type = this.value;

	$.ajax({
		url: js_site_url('cart_module/cart_module/order_type'),
		type: 'post',
		data: 'order_type=' + order_type,
		dataType: 'json',
		success: function(json) {
			$('.delivery-info, .collection-info').fadeOut();
			$('#cart-alert .alert').remove();

			if (json['error']) {
				$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['error'] + '</div>');
				$('.alert').fadeIn('slow');
			}

			if (order_type == '1') {
				$('.delivery-info').fadeIn();
				$('.collection-info').fadeOut();
			} else {
				$('.delivery-info').fadeOut();
				$('.collection-info').fadeIn();
			}

			$('#cart-info, #cart-info-dropdown').load(js_site_url('cart_module/cart_module #cart-info > *'));
		}
	});
});

$(document).ready(function() {
	$('.panel-body input[name="order_type"]:checked').trigger('change');
});

function applyCoupon() {
	var coupon_code = $('#cart-box input[name="coupon_code"]').val();
	$.ajax({
		url: js_site_url('cart_module/cart_module/coupon?action=add'),
		type: 'post',
		data: 'code=' + coupon_code,
		dataType: 'json',
		success: function(json) {
			$('#cart-alert .alert').remove();
			if(json['redirect']) {
				window.location.href = json['redirect'];
			}

			if (json['error']) {
				$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['error'] + '</div>');
				$('.alert').fadeIn('slow');
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}

			if (json['success']) {
				$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['success'] + '</div>');
				$('.alert').fadeIn('slow');
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}

			$('#cart-info, #cart-info-dropdown').load(js_site_url('cart_module/cart_module #cart-info > *'));
		}
	});
}

function clearCoupon(coupon_code) {
	$('input[name=\'coupon\']').attr('value', '');

	$.ajax({
		url: js_site_url('cart_module/cart_module/coupon?action=remove'),
		type: 'post',
		data: 'code=' + coupon_code,
		dataType: 'json',
		success: function(json) {
			$('#cart-alert .alert').remove();
			if (json['success']) {
				$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['success'] + '<span class="close alert-dismissable"></span></div>');
				$('.alert').fadeIn('slow');
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}

			$('#cart-info, #cart-info-dropdown').load(js_site_url('cart_module/cart_module #cart-info > *'));
		}
	});
}
//--></script>