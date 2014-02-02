function searchLocal() {
	
	var postcode = $('input[name=\'postcode\']').val();

	$.ajax({
		url: js_site_url + 'main/local_module/distance',
		type: 'post',
		data: 'postcode=' + postcode,
		dataType: 'json',
		success: function(json) {
			$('#notification p').remove();

			if(json['redirect']) {
				window.location.href = json['redirect'];
			}
					
			if (json['error']) {
				$('#notification').html(json['error']);
			
				$('.error').fadeIn('slow');
							
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}
		
			$('#local-info').load(js_site_url + 'main/local_module #local-info > *');
		}
	});
}

function addToCart(menu_id) {
	
	var menu_options = $('#' + menu_id).find('input:checked').val();
	var quantity 	= $('#' + menu_id).find('select[name=\'quantity\']').val();

	$.ajax({
		url: js_site_url + 'main/cart_module/add',
		type: 'post',
		data: 'menu_id=' + menu_id + '&menu_options=' + menu_options + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('#cart-alert p').remove();

			if(json['redirect']) {
				window.location.href = json['redirect'];
			}
					
			if (json['error']) {
				$('#cart-alert').html('<p class="error" style="display: none;">' + json['error'] + '</p>');
			
				$('.error').fadeIn('slow');
							
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}
		
			if (json['success']) {
				$('#cart-alert').html('<p class="success" style="display: none;">' + json['success'] + '</p>');
			
				$('.success').fadeIn('slow');
							
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	

			$('#cart-info').load(js_site_url + 'main/cart_module #cart-info > *');
		}
	});
}

function updateCart(menu_id, row_id) {

	var quantity = $('#' + row_id).find('select').val();

	$.ajax({
		url: js_site_url + 'main/cart_module/update',
		type: 'post',
		data: 'menu_id' + menu_id + '&row_id=' + row_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('#cart-alert p').remove();

			if(json['redirect']) {
				window.location.href = json['redirect'];
			}
					
			if (json['error']) {
				$('#cart-alert').html('<p class="error" style="display: none;">' + json['error'] + '</p>');
			
				$('.error').fadeIn('slow');

				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}
		
			if (json['success']) {
				$('#cart-alert').html('<p class="success" style="display: none;">' + json['success'] + '</p>');
			
				$('.success').fadeIn('slow');
			
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	

			$('#cart-info').load(js_site_url + 'main/cart_module #cart-info > *');
		}
	});
}

function applyCoupon() {

	var code = $('input[name=\'coupon\']').val();

	$.ajax({
		url: js_site_url + 'main/cart_module/coupon',
		type: 'post',
		data: 'code=' + code,
		dataType: 'json',
		success: function(json) {
			$('#cart-alert p').remove();

			if(json['redirect']) {
				window.location.href = json['redirect'];
			}
					
			if (json['error']) {
				$('#cart-alert').html('<p class="error">' + json['error'] + '</p>');
			
				$('.error').fadeIn('slow');

				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}
		
			if (json['success']) {
				$('#cart-alert').html('<p class="success">' + json['success'] + '</p>');
			
				$('.success').fadeIn('slow');
			
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	

			$('#cart-info').load(js_site_url + 'main/cart_module #cart-info > *');
		}
	});
}

function clearLocal() {
	$('.check-local').show();
	$('.display-local').hide();
}

function clearCoupon() {
	$('input[name=\'coupon\']').attr('value', '');

	$.ajax({
		url: js_site_url + 'main/cart_module/coupon',
		dataType: 'json',
		success: function(json) {
			$('#cart-alert p').remove();
			
			if (json['error']) {
				$('#cart-alert').html('<p class="error">' + json['error'] + '</p>');
			
				$('.success').fadeIn('slow');
			
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}

			$('#cart-info').load(js_site_url + 'main/cart_module #cart-info > *');
		}
	});
}

function confirmOrder() {
	document.getElementById("checkout-form").submit();
	document.getElementById("delivery-form").submit();
	document.getElementById("payment-form").submit();
}

function reserveTable() {
	document.getElementById("reserve-form").submit();
}

function addReview(formID) {

	var menu_id = $(formID).find('input[name=\'menu_id\']').val();
	var customer_id = $(formID).find('input[name=\'customer_id\']').val();
	var customer_name = $(formID).find('input[name=\'customer_name\']').val();
	var rating_id = $(formID).find('select[name=\'rating_id\']').val();
	var review_text = $(formID).find('textarea[name=\'review_text\']').val();

	$.ajax({
		url: js_site_url + 'menus/review',
		type: 'post',
		data: 'menu_id=' + menu_id + '&customer_id=' + customer_id + '&customer_name=' + customer_name + '&rating_id=' + rating_id + '&review_text=' + review_text,
		dataType: 'json',
		success: function(json) {
			//$(formID).remove('select');
			//$('#review-notification .error, #review-notification .success').remove();


			if (json['error']) {
				$('#review-notification').html('<p class="error" style="display: none;">' + json['error'] + '</p>');
			
				$('.error').fadeIn('slow');
			
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 

			}
			
			if (json['success']) {
				$('#review-box').html('<p class="success">' + json['success'] + '</p>');
			
				$('#review-box').fadeIn(1000).delay(3000).fadeOut(1500, function() {
					$('#opaclayer').hide().css('opacity','1');
				});				
			}	
		}
	});
}

function openReviewBox(menu_id) {
	$('#review-box').load(js_site_url + 'menus/write_review?menu_id=' + menu_id + ' #write-review > *');
	var opaclayerHeight = $(document).height();
	var opaclayerWidth = $(window).width();
	$('#opaclayer').css('height', opaclayerHeight);
	$('#opaclayer').css('width', opaclayerWidth);
	var winH = $(window).height();
	var winW = $(window).width();
	$('#review-box').css('top',  winH/2-$('#review-box').height()/2);
	$('#review-box').css('left', winW/2-$('#review-box').width()/2);				
	$('#opaclayer').fadeTo(500,0.8);
	$('#review-box').fadeIn(500);
}

function closeReviewBox() {
	$('#opaclayer').fadeOut(500, function() {
		$('#opaclayer').hide().css('opacity','1');
	});
	$('#review-box').fadeOut(500, function() {
		$('#review-box').hide();
	});
}