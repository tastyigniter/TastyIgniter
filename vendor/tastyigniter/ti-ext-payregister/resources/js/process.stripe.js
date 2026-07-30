+function ($) {
    "use strict"

    var ProcessStripe = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.$checkoutFormContainer = this.$el.closest('[data-control="checkout"]')
        this.$checkoutForm = this.$checkoutFormContainer.find('form')
        this.$checkoutBtn = $('[data-checkout-control="submit"]')
        this.stripe = null
        this.elements = null
        this.paymentElement = null

        this.init()
    }

    ProcessStripe.prototype.dispose = function () {
        this.stripe = null
        this.elements = null
    }

    ProcessStripe.prototype.init = function () {
        if (this.$checkoutFormContainer.checkout('selectedPaymentInput').val() !== 'stripe') return

        if (!$(this.options.cardSelector).length || $(this.options.cardSelector+' iframe').length)
            return

        if (this.options.publishableKey === undefined || !this.options.publishableKey)
            throw new Error('Missing stripe publishable key, configure publishableKey in the payment method settings.')

        var self = this

        this.initStripe()

        this.$checkoutForm
            .on('submitCheckoutForm', $.proxy(this.submitFormHandler, this))
            .on('submit', function () {
                if (self.$checkoutForm.find('input[name="fields.payment"]:checked').val() !== 'stripe')
                    return

                self.paymentElement?.update({readOnly: true});
            })
            .on('ajaxFail', function () {
                self.paymentElement?.update({readOnly: false});
            })
    }

    ProcessStripe.prototype.initStripe = function () {
        if (!this.options.paymentIntentSecret) return;

        // Create a Stripe client.
        this.stripe = Stripe(this.options.publishableKey, this.options.stripeOptions)

        // Used by Stripe to identify this integration
        this.stripe.registerAppInfo({
            name: "TastyIgniter Stripe",
            partner_id: this.options.partnerId,  // Used by Stripe to identify this integration
            url: 'https://tastyigniter.com/marketplace/item/igniter-payregister'
        });

        // Create an instance of the card Element.
        this.elements = this.stripe.elements({
            clientSecret: this.options.paymentIntentSecret,
        })

        this.paymentElement = this.elements.create('payment', {
            layout: {
                type: 'tabs'
            },
        })

        // Add an instance of the card Element into the `card-element` <div>.
        this.paymentElement.mount(this.options.cardSelector);

        // Handle real-time validation errors from the card Element.
        this.paymentElement.addEventListener('change', $.proxy(this.validationErrorHandler, this))
    }

    ProcessStripe.prototype.validationErrorHandler = function (event) {
        $('[data-checkout-control="submit"]').prop('disabled', false)
        this.paymentElement.update({readOnly: false});
    }

    ProcessStripe.prototype.submitFormHandler = function (event) {
        var self = this,
            $form = this.$checkoutForm

        if (this.$checkoutFormContainer.checkout('selectedPaymentInput').val() !== 'stripe') return

        // Prevent the form from submitting with the default action
        event.preventDefault()

        self.$checkoutBtn.prop('disabled', true)

        this.stripe.confirmPayment({
            elements: this.elements,
            redirect: 'if_required',
        }).then(function (result) {
            var paymentIntentStatus = (result.error && result.error.payment_intent)
                ? result.error.payment_intent.status : null

            if (result.error && !(paymentIntentStatus === 'requires_capture' || paymentIntentStatus === 'succeeded')) {
                // Inform the user if there was an error.
                self.$checkoutBtn.prop('disabled', false)
                self.validationErrorHandler(result)
            } else {
                // Switch back to default to submit form
                $form.unbind('submitCheckoutForm').submit()
            }
        });
    }

    ProcessStripe.DEFAULTS = {
        publishableKey: undefined,
        paymentIntentSecret: undefined,
        stripeOptions: undefined,
        partnerId: 'pp_partner_JZyCCGR3cOwj9S',
        cardSelector: '#stripe-card-element',
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.processStripe

    $.fn.processStripe = function (option) {
        var $this = $(this).first()
        var options = $.extend(true, {}, ProcessStripe.DEFAULTS, $this.data(), typeof option == 'object' && option)

        return new ProcessStripe($this, options)
    }

    $.fn.processStripe.Constructor = ProcessStripe

    $.fn.processStripe.noConflict = function () {
        $.fn.processStripe = old
        return this
    }

    $(document).render(function () {
        $('#stripePaymentForm').processStripe()
    })
}(window.jQuery)
