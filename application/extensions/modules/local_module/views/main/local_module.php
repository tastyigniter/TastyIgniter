<div id="local-box" class="row">
	<div id="local-info">
		<div class="display-local" style="display: <?php echo ($local_info ? 'block' : 'none'); ?>">
			<div class="col-xs-4">
				<address>
					<strong><?php echo $location_name; ?></strong><br />	
					<?php echo $location_address; ?>
				</address>
			</div>
			<div class="col-xs-3">
				<label for="order-type" class="small"><b><?php echo $text_avail; ?></b>:</label><small> <?php echo $text_delivery; ?></small>
				<select name="order_type" id="order-type" class="form-control" onChange="setOrderType();">
					<?php if ($order_type === '1') { ?>
						<option value="1" selected="selected">Delivery</option>
						<option value="2">Collection</option>
					<?php } else if ($order_type === '2') { ?>
						<option value="1">Delivery</option>
						<option value="2" selected="selected">Collection</option>
					<?php } else { ?>
						<option value="1">Delivery</option>
						<option value="2">Collection</option>
					<?php } ?>
				</select>
				<?php if (!empty($text_covered)) { ?>
					<br /><span class="text-xs text-danger"><?php echo $text_covered; ?></span><br />
				<?php } ?>
			</div>
			<div class="col-xs-3">
				<span class="small"><?php echo $text_open_or_close; ?></span><br />
				<span class="small"><?php echo $text_delivery_charge; ?>: <?php echo $delivery_charge; ?></span><br />
				<span class="small"><?php echo $text_min_total; ?>: <?php echo $min_total; ?></span>
			</div>
			<div class="col-xs-2 text-center">
				<a class="btn btn-default" onclick="clearLocal();" id="check-postcode"><?php echo $button_check_postcode; ?></a><br />
				<a class="small" href="<?php echo $info_url; ?>"><?php echo $text_more_info; ?></a> | 
				<span class="small"><?php echo $text_total_review; ?></span>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="check-local" style="display: <?php echo ($local_info ? 'none' : 'block'); ?>">
		<form id="location-form" method="POST" action="<?php echo site_url('local_module/main/local_module/distance'); ?>">
			<div class="col-xs-12 text-center">
				<div class="form-group">
					<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
					<div class="col-sm-4 center-block">
						<div class="input-group input-group-sm postcode-group">
							<input type="text" id="postcode" class="form-control text-center postcode-control" name="postcode" value="<?php echo $postcode; ?>">
							<a class="input-group-addon btn btn-success" onclick="searchLocal();"><?php echo $text_find; ?></a>
						</div>
					</div>
					<div id="local-alert">
						<?php if ($local_alert) { ?>
							<div class="alert">
								<?php echo $local_alert; ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
<?php if ( ! $local_page) { ?>
<script type="text/javascript">//<!--
function searchLocal() {
	var postcode = $('input[name=\'postcode\']').val();

	$.ajax({
		url: js_site_url('local_module/main/local_module/distance'),
		type: 'post',
		data: 'postcode=' + postcode,
		dataType: 'json',
		success: function(json) {
			$('#local-alert .alert').remove();

			if(json['redirect']) {
				window.location.href = json['redirect'];
			}
					
			if (json['error']) {
				$('#local-alert').append('<div class="alert" style="display:none;">' + json['error'] + '</div>');
				$('.alert').fadeIn('slow');
			} else {
				$('#local-info').load(js_site_url('local_module/main/local_module #local-info > *'));
			}
		
			$('#cart-info').load(js_site_url('main/cart_module #cart-info > *'));
		}
	});
}

function setOrderType() {
	$.ajax({
		url: js_site_url('local_module/main/local_module/distance'),
		type: 'post',
		data: 'postcode=' + $('input[name=\'postcode\']').val() + '&order_type=' + $('select[name=\'order_type\']').val(),
		dataType: 'json',
		success: function(json) {}
	});
}

function clearLocal() {
	$('.check-local').show();
	$('.display-local').hide();
}

//--!></script>
<?php } ?>