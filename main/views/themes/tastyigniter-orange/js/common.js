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

$(function() {
    var alertMsgs = $('.alert-collapsible .alert-hide');
    var dropdownButton = $('.btn-dropdown');
    alertMsgs.hide();

    //Click dropdown
    dropdownButton.click(function() {
        //get data-for attribute
        //var dataFor = $(this).attr('data-for');
        //var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        alertMsgs.slideToggle(function() {
            //Completed slidetoggle
            if(alertMsgs.is(':visible')) {
                currentButton.html('<i class="fa fa-chevron-up text-muted"></i>');
            } else {
                currentButton.html('<i class="fa fa-chevron-down text-muted"></i>');
            }
        })
    });
})

function addToCart(menu_id) {
	if ($('#menu-options' + menu_id).length) {
		var data = $('#menu-options' + menu_id + ' input:checked, #menu-options' + menu_id + ' input[type="hidden"], #menu-options' + menu_id + ' select, #menu-options' + menu_id + '  input[type="text"]');
	} else {
		var data = 'menu_id=' + menu_id;
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

			if (json['options']) {
				if (json['error']) {
					$('#cart-options-alert .alert').remove();

					$('#cart-options-alert').append('<div class="alert" style="display: none;">' + alert_close + json['error'] + '</div>');
					$('#cart-options-alert .alert').fadeIn('slow');

					$('#menu'+menu_id+ ' .add_cart').addClass('failed');
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

					$('#menu'+menu_id+ ' .add_cart').addClass('failed');
				}

				if (json['success']) {
					$('#cart-alert').append('<div class="alert" style="display: none;">' + alert_close + json['success'] + '</div>');
					$('.alert').fadeIn('slow');

					$('#menu'+menu_id+ ' .add_cart').addClass('added');
				}

				$('#cart-info, #cart-info-dropdown').load(js_site_url('cart_module/cart_module #cart-info > *'));
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

			$('#cart-info, #cart-info-dropdown').load(js_site_url('cart_module/cart_module #cart-info > *'));
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

$(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'fa fa-check-square-o'
                },
                off: {
                    icon: 'fa fa-square-o'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i>');
            }
        }
        init();
    });
});