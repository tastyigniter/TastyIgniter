jQuery(function() {
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_test_d5BEDmaLhu6JeckNBeAWYcyq');

    $('[data-numeric]').payment('restrictNumeric');
    $('[data-stripe="number"]').payment('formatCardNumber');
    $('[data-stripe="cvc"]').payment('formatCardCVC');

    $.fn.toggleInputError = function(hasError) {
        this.closest('.form-group').toggleClass('has-error', hasError);
        if (hasError) appendError('Card validation failed, please check your details');
        return this;
    };

    $('#checkout-form').submit(function(event) {
        var $form = $(this);
        var $button = $('#cart-box .cart-buttons .btn');
        var $paymentInput = $form.find('input[name="payment"]:checked');

        if ($paymentInput.val() === 'stripe') {
            var cardType = $.payment.cardType($('[data-stripe="number"]').val());
            $('[data-stripe="number"]').toggleInputError(!$.payment.validateCardNumber($('[data-stripe="number"]').val()));
            $('[data-stripe="exp-month"]').toggleInputError(!$.payment.validateCardExpiry($('[data-stripe="exp-month"]').val(), $('[data-stripe="exp-year"]').val()));
            $('[data-stripe="cvc"]').toggleInputError(!$.payment.validateCardCVC($('[data-stripe="cvc"]').val(), cardType));

            if (!$('#stripe-payment .has-error').length) {
                // Disable the submit button to prevent repeated clicks
                $button.addClass('disabled');

                Stripe.card.createToken($form, stripeResponseHandler);
            }

            // Prevent the form from submitting with the default action
            event.preventDefault();
            return false;
        }
    });

    function stripeResponseHandler(status, response) {
        var $form = $('#checkout-form');
        var $button = $('#cart-box .cart-buttons .btn');

        if (response.error) {
            // Show the errors on the form
            appendError(response.error.message);
            $button.removeClass('disabled');
        } else {
            // response contains id and card, which contains additional card details
            var token = response.id;
            // Insert the token into the form so it gets submitted to the server
            $('#stripe-payment').append($('<input type="hidden" name="stripe_token" />').val(token));
            // and submit
            $form.get(0).submit();
        }
    }

    function appendError(message) {
        $('#checkout-form .stripe-errors').html('<p class="alert alert-danger">' + message + '</p>');
    }
});