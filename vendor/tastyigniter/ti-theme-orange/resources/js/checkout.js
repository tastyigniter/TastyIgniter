+function ($) {
    "use strict"

    if ($.fn.checkout === undefined)
        $.fn.checkout = {}

    var Checkout = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.paymentInputSelector = 'input[name="'+this.options.paymentInputName+'"]'
        this.$form = $(this.options.formSelector)
        this.$checkoutBtn = $(this.options.buttonSelector)

        this.init()
    }

    Checkout.prototype.init = function () {
        var self = this
        $(document)
            .on('click', '[data-checkout-control]', $.proxy(this.onControlClick, this))
            .on('change', '[data-checkout-control=payment]', function (event) {
                self.choosePayment($(event.currentTarget))
            })
            .on('ajaxBeforeSend', this.options.buttonSelector, function () {
                $(this).prop('disabled', true)
            })
            .on('ajaxFail', this.options.buttonSelector, function () {
                $(this).prop('disabled', false)
                self.$checkoutBtn.prop('disabled', false)
            })
            .on('submit', this.options.formSelector, $.proxy(this.onSubmitCheckoutForm, this))

        Livewire.on('checkout::validated', (message) => {
            self.completeCheckout();
        })

        Livewire.hook('morph.updating', ({el, component, toEl, skip, childrenOnly}) => {
            if (this.$checkoutBtn.data('skipValidation')
                && ($(el).data('toggle') === 'payments' || $(el).is(this.options.buttonSelector))) {
                skip()
            }
        })
    }

    Checkout.prototype.selectedPaymentInput = function () {
        return this.$el.find(this.paymentInputSelector+':checked')
    }

    Checkout.prototype.completeCheckout = function () {
        var _event = jQuery.Event('submitCheckoutForm')
        this.$form.trigger(_event)
        if (_event.isDefaultPrevented()) {
            return false;
        }

        Livewire.dispatch(this.options.confirmEvent);
    }

    Checkout.prototype.choosePayment = function ($el) {
        var $paymentContainer = $el.closest('[data-checkout-payment]'),
            $paymentInput = $paymentContainer.find(this.paymentInputSelector)

        if (!$paymentInput.length || $paymentInput.prop('readonly'))
            return

        this.$form.off('submitCheckoutForm')

        $(this.paymentInputSelector, document).prop('readonly', true)
        Livewire.dispatch(this.options.choosePaymentEvent, {code: $paymentInput.data('paymentCode')});
    }

    Checkout.prototype.deletePaymentProfile = function ($el) {
        Livewire.dispatch(this.options.deletePaymentProfileEvent, {code: $el.data('paymentCode')});
    }

    Checkout.prototype.setPaymentFieldsComponentProperties = function () {
        var $paymentContainer = this.$el.find('[data-checkout-payment].selected'),
            checkoutComponentId = this.$el.closest('[wire\\:id]').attr('wire:id'),
            checkoutComponent,
            paymentFields = {};

        // Get all hidden input values and store in a key value array
        $paymentContainer.find('input, select').each(function () {
            var $el = $(this),
                name = $el.attr('name'),
                type = $el.attr('type');

            if (!name.length || name.startsWith('fields.')) return;

            if (['radio', 'checkbox'].indexOf(type) !== -1 && !$el.prop('checked')) return;

            paymentFields[name] = $el.val();
        });

        if ((checkoutComponent = Livewire.find(checkoutComponentId)) && Object.keys(paymentFields).length) {
            checkoutComponent.$set('fields.payment_fields', paymentFields, false)
        }
    }

    // EVENT HANDLERS
    // ============================

    Checkout.prototype.onControlClick = function (event) {
        var $el = $(event.currentTarget),
            control = $el.data('checkoutControl')

        if (control === 'payment-label') {
            this.choosePayment($el)
        } else if (control === 'delete-payment-profile') {
            this.deletePaymentProfile($el, event)
        }
    }

    Checkout.prototype.onSubmitCheckoutForm = function (event) {
        var $selectedPaymentMethod = this.selectedPaymentInput()

        event.preventDefault();

        this.setPaymentFieldsComponentProperties()

        if (!this.$checkoutBtn.data('skipValidation') && $selectedPaymentMethod.length && $selectedPaymentMethod.data('preValidateCheckout') === true) {
            this.$checkoutBtn.data('skipValidation', true)
            Livewire.dispatch(this.options.validateEvent);
            return false;
        }

        this.completeCheckout();
    }

    Checkout.DEFAULTS = {
        alias: 'checkout',
        wireId: undefined,
        formSelector: '#checkout-form',
        buttonSelector: '[data-checkout-control="submit"]',
        paymentInputName: 'payment',
        confirmEvent: undefined,
        validateEvent: undefined,
        choosePaymentEvent: undefined,
        deletePaymentProfileEvent: undefined,
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.checkout

    $.fn.checkout = function (option) {
        var args = arguments,
            result = undefined

        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.checkout')
            var options = $.extend({}, Checkout.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.checkout', (data = new Checkout(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.checkout.Constructor = Checkout

    $.fn.checkout.noConflict = function () {
        $.fn.checkout = old
        return this
    }

    $(document).render(function () {
        $('[data-control="checkout"]').checkout()
    })
}(window.jQuery)
