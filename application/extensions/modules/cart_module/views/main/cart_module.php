<div id="cart-box" class="module-box">
	<?php if (!empty($text_closed)) { ?>
		<div class="text-danger text-center well"><b><?php echo $text_closed; ?></b></div>
	<?php } ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $text_my_order; ?></h3>
		</div>

		<div id="cart-alert">
			<?php if ($cart_alert) { ?>
			<div class="alert alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $cart_alert; ?>
			</div>
			<?php } ?>
		</div>
	
		<div class="panel-body">
			<div class="form-inline text-center text-muted">
				<div id="search-query" class="input-group input-group-sm postcode-group wrap-bottom" style="display:<?php echo (!empty($alert_no_postcode)) ? 'block' : 'none'; ?>">
					<input type="text" id="postcode" class="form-control text-center postcode-control" name="postcode" placeholder="My Postcode" value="<?php echo $search_query; ?>">
					<a class="input-group-addon btn btn-success" onclick="searchLocal();"><?php echo $text_find; ?></a>
				</div>

				<div id="my-postcode" class="wrap-bottom" style="display:<?php echo (empty($alert_no_postcode)) ? 'block' : 'none'; ?>">
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
			</div>
			<div class="delivery-info text-center wrap-horizontal" style="display:<?php echo ($order_type === '1') ? 'block' : 'none'; ?>">
				<span class="small"><?php echo $delivery_time; ?></span><br />
				<span class="small"><?php echo $delivery_charge; ?></span><br />
				<span class="small"><?php echo $text_min_total; ?>: <?php echo $min_total; ?></span><br />
			</div>
			<div class="collection-info text-center wrap-horizontal" style="display:<?php echo ($order_type === '2') ? 'block' : 'none'; ?>;">
				<span class="small"><?php echo $collection_time; ?></span><br />
			</div>
		</div>
	
		<div id="cart-info">
			<?php if ($cart_items) {?>
				<div class="cart-items">
					<div class="table-responsive">
						<table width="100%" height="auto" class="table">
							<tbody>
								<?php foreach ($cart_items as $cart_item) { ?>
								<tr id="<?php echo $cart_item['rowid']; ?>">
									<td width="1"><?php echo $cart_item['qty']; ?>x<br />
									<td width="55%" class="left"><a class="menu-name" onClick="openMenuOptions('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>');"><?php echo $cart_item['name']; ?></a>
									<?php if (!empty($cart_item['options'])) { ?>
										<div><small>+ <?php echo $cart_item['options']; ?></small></div>
									<?php } ?>
									</td>
									<!--<td><?php echo $cart_item['price']; ?></td>-->
									<td><?php echo $cart_item['sub_total']; ?></td>
									<td><a onClick="removeCart('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>', '0');"><span class="fa fa-times"></span></a></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>

				<div class="cart-coupon">
					<div class="table-responsive">
						<table width="100%" height="auto" class="table table-none">
							<tbody>
								<tr>
									<td class="text-right"><input type="text" name="coupon" class="form-control pull-right" value="<?php echo $coupon_code; ?>" placeholder="<?php echo $text_apply_coupon; ?>" /></td>
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
								<?php if (!empty($coupon)) { ?>
								<tr>
									<td><b><?php echo $text_coupon; ?>:</b></td>
									<td class="text-right"><a onclick="clearCoupon();"><span class="fa fa-times"></span></a>
									&nbsp;&nbsp;-<?php echo $coupon; ?></td>
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
									<td class="text-right"><?php echo $order_total; ?></td>
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
		url: js_site_url('local_module/main/local_module/search'),
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
				$('#cart-box > .panel > .panel-body').load(js_site_url('cart_module/main/cart_module #cart-box > .panel > .panel-body > *'));
				$('#local-info').load(js_site_url('local_module/main/local_module #local-info > *'));
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
		url: js_site_url('cart_module/main/cart_module/order_type'),
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

			$('#cart-info').load(js_site_url('cart_module/main/cart_module #cart-info > *'));
		}
	});
});
	
$(document).ready(function() {
	$('.panel-body input[name="order_type"]:checked').trigger('change');
});

function addToCart(menu_id) {
	if ($('#menu-options' + menu_id).length) {
		var data = $('#menu-options' + menu_id + ' input:checked, #menu-options' + menu_id + ' input[type="hidden"], #menu-options' + menu_id + ' select, #menu-options' + menu_id + '  input[type="text"]');
	} else {
		var data = 'menu_id=' + menu_id;
	}
	
	$.ajax({
		url: js_site_url('cart_module/main/cart_module/add'),
		type: 'post',
		data: data,
		dataType: 'json',
		success: function(json) {
			if (json['options']) {
				if (json['error']) {
					$('#cart-options-alert .alert').remove();
	
					$('#cart-options-alert').append('<div class="alert" style="display: none;">' + alert_close + json['error'] + '</div>');
					$('#cart-options-alert .alert').fadeIn('slow');
				}
			} else {
				$('#optionsModal').modal('hide');
				$('#cart-alert .alert').remove();
			
				if (json['redirect']) {
					window.location.href = json['redirect'];
				}
					
				if (json['error']) {
					$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['error'] + '</div>');
					$('.alert').fadeIn('slow');
				}
		
				if (json['success']) {
					$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['success'] + '</div>');
					$('.alert').fadeIn('slow');
				}	

				$('#cart-info').load(js_site_url('cart_module/main/cart_module #cart-info > *'));
			}
		}
	});
}

function openMenuOptions(menu_id, row_id) {
	if (menu_id) {
		var row_id = (row_id) ? row_id : '';
		
		$.ajax({
			url: js_site_url('cart_module/main/cart_module/options?menu_id=' + menu_id + '&row_id=' + row_id),
			dataType: 'html',
			success: function(html) {
				$('#optionsModal').remove();
				$('body').append('<div id="optionsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>');
				$('#optionsModal').html(html);
				$('select.form-control').selectpicker('refresh');
				
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
		url: js_site_url('cart_module/main/cart_module/remove'),
		type: 'post',
		data: 'menu_id' + menu_id + '&row_id=' + row_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('#cart-alert .alert').remove();
			if(json['redirect']) {
				window.location.href = json['redirect'];
			}
					
			if (json['error']) {
				$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['error'] + '</div>');
				$('.alert').fadeIn('slow');
			}
		
			if (json['success']) {
				$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['success'] + '</div>');
				$('.alert').fadeIn('slow');
			}	

			$('#cart-info').load(js_site_url('cart_module/main/cart_module #cart-info > *'));
		}
	});
}

function applyCoupon() {
	var code = $('input[name=\'coupon\']').val();

	$.ajax({
		url: js_site_url('cart_module/main/cart_module/coupon'),
		type: 'post',
		data: 'code=' + code,
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

			$('#cart-info').load(js_site_url('cart_module/main/cart_module #cart-info > *'));
		}
	});
}

function clearCoupon() {
	$('input[name=\'coupon\']').attr('value', '');

	$.ajax({
		url: js_site_url('cart_module/main/cart_module/coupon?remove=1'),
		dataType: 'json',
		success: function(json) {
			$('#cart-alert .alert').remove();
			if (json['success']) {
				$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['success'] + '<span class="close alert-dismissable"></span></div>');
				$('.alert').fadeIn('slow');
				//$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}

			$('#cart-info').load(js_site_url('cart_module/main/cart_module #cart-info > *'));
		}
	});
}
//--></script>