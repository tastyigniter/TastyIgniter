$.fn.tabs = function() {
	var selector = this;
	
	this.each(function() {
		var obj = $(this); 
		
		$(obj.attr('rel')).hide();
		
		$(obj).click(function() {
			$(selector).removeClass('active');
			
			$(selector).each(function(i, element) {
				$($(element).attr('rel')).hide();
			});
			
			$(this).addClass('active');
			
			$($(this).attr('rel')).show();
			
			return false;
		});
	});

	$(this).show();
	
	$(this).first().click();
};

function addToCart(menu_id) {
	
	var menu_options = $('#' + menu_id).find('input:checked').val();
	var quantity 	= $('#' + menu_id).find('select[name=\'quantity\']').val();

	$.ajax({
		url: js_site_url('main/cart_module/add'),
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
							
				//$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}
		
			if (json['success']) {
				$('#cart-alert').html('<p class="success" style="display: none;">' + json['success'] + '</p>');
			
				$('.success').fadeIn('slow');
							
				//$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	

			$('#cart-info').load(js_site_url('main/cart_module #cart-info > *'));
		}
	});
}

function updateCart(menu_id, row_id, quantity) {

	var quantity = '0';

	$.ajax({
		url: js_site_url('main/cart_module/update'),
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

				//$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}
		
			if (json['success']) {
				$('#cart-alert').html('<p class="success" style="display: none;">' + json['success'] + '</p>');
			
				$('.success').fadeIn('slow');
			
				//$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	

			$('#cart-info').load(js_site_url('main/cart_module #cart-info > *'));
		}
	});
}

function applyCoupon() {

	var code = $('input[name=\'coupon\']').val();

	$.ajax({
		url: js_site_url('main/cart_module/coupon'),
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

			$('#cart-info').load(js_site_url('main/cart_module #cart-info > *'));
		}
	});
}

function clearCoupon() {
	$('input[name=\'coupon\']').attr('value', '');

	$.ajax({
		url: js_site_url('main/cart_module/coupon?remove=1'),
		dataType: 'json',
		success: function(json) {
			$('#cart-alert p').remove();
			
			if (json['success']) {
				$('#cart-alert').html('<p class="success">' + json['success'] + '</p>');
			
				$('.success').fadeIn('slow');
			
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}

			$('#cart-info').load(js_site_url('main/cart_module #cart-info > *'));
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
		url: js_site_url('menus/review'),
		type: 'post',
		data: 'menu_id=' + menu_id + '&customer_id=' + customer_id + '&customer_name=' + customer_name + '&rating_id=' + rating_id + '&review_text=' + review_text,
		dataType: 'json',
		success: function(json) {

			if (json['error']) {
				$('#review-notification').html('<p class="error" style="display: none;">' + json['error'] + '</p>');
			
				$('.error').fadeIn('slow');
			}
			
			if (json['success']) {
				$('#review-notification').html('<p class="success" style="display: none;">' + json['success'] + '</p>');
				$('#review-box table, #review-box .buttons').empty();
				$('.success').fadeIn('slow').delay(3000).fadeOut(1500, function() {
					//jQuery('#cboxClose').click();
					$.colorbox.close();
				});				
			}	
		}
	});
}