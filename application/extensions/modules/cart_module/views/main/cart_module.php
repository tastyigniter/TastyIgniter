<div id="cart-box" class="module-box">
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
	
		<div id="cart-info">
		<?php if ($cart_items) {?>
			<div style="display:none;">
				<table width="100%" height="auto" class="table">
					<thead>
						<tr>
							<th></th>
							<th class="text-left"><?php echo $column_menu; ?></th>
							<!--<th><?php echo $column_price; ?></th>-->
							<th><?php echo $column_total; ?></th>
							<th></th>
						</tr>
					</thead>
				</table>
			</div>

			<div class="cart-info">
				<div class="table-responsive">
					<table width="100%" height="auto" class="table">
						<tbody>
							<?php foreach ($cart_items as $cart_item) { ?>
							<tr id="<?php echo $cart_item['rowid']; ?>">
								<td width="1"><?php echo $cart_item['qty']; ?>x<br />
								<td width="55%" class="left"><b><?php echo $cart_item['name']; ?></b><br />
								<?php if (!empty($cart_item['options'])) { ?>
									<div><small>+ <?php echo $cart_item['options']['name']; ?> : <?php echo $cart_item['options']['price']; ?></small></div>
								<?php } ?>
								</td>
								<!--<td><?php echo $cart_item['price']; ?></td>-->
								<td><?php echo $cart_item['sub_total']; ?></td>
								<td><a onClick="updateCart('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>', '0');"><span class="fa fa-times"></span></a></td>
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
								<td class="text-right"><b><?php echo $text_sub_total; ?>:</b> <?php echo $sub_total; ?></td>
							</tr>
							<?php } ?>
							<?php if (!empty($coupon)) { ?>
							<tr>
								<td class="text-right"><a onclick="clearCoupon();"><span class="fa fa-times"></span></a>
								<b><?php echo $text_coupon; ?>:</b> -<?php echo $coupon; ?></td>
							</tr>
							<?php } ?>
							<?php if (!empty($delivery)) { ?>
							<tr>
								<td class="text-right"><b><?php echo $text_delivery; ?>:</b> <?php echo $delivery; ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td class="text-right"><b><?php echo $text_order_total; ?>:</b> <?php echo $order_total; ?></td>
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
	<div class="buttons wrap-all">
		<div class="text-right">
			<?php echo $button_order; ?>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript"><!--
var alert_close = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

function addToCart(menu_id) {
	var menu_options = $('#' + menu_id).find('input:checked').val();
	var quantity 	= $('#' + menu_id).find('select[name=\'quantity\']').val();

	$.ajax({
		url: js_site_url('cart_module/main/cart_module/add'),
		type: 'post',
		data: 'menu_id=' + menu_id + '&menu_options=' + menu_options + '&quantity=' + quantity,
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

function updateCart(menu_id, row_id, quantity) {
	var quantity = '0';

	$.ajax({
		url: js_site_url('cart_module/main/cart_module/update'),
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