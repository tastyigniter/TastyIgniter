+function ($) {
    "use strict"

    var ProcessSquare = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.$checkoutForm = this.$el.closest('[data-control="checkout"]')
        this.card = null
        this.payments = null

        this.init()
    }

    ProcessSquare.prototype.init = function () {
        if (this.$checkoutForm.checkout('selectedPaymentInput').val() !== 'square') return

        if (!$(this.options.cardSelector).length || $(this.options.cardSelector+' iframe').length)
            return

        if (this.options.applicationId === undefined)
            throw new Error('Missing square application id')

        this.payments = window.Square.payments(this.options.applicationId, this.options.locationId);

        this.initializeCard(this.payments).catch(e => {
            throw new Error('Initializing Card failed', e)
        });

        this.$checkoutForm.on('submitCheckoutForm', $.proxy(this.submitFormHandler, this))
    }

    ProcessSquare.prototype.initializeCard = async function (payments) {
        this.card = await payments.card({
            style: this.options.cardFormStyle
        });
        await this.card.attach(this.options.cardSelector);
    }

    ProcessSquare.prototype.submitFormHandler = async function (event) {
        if (this.$checkoutForm.checkout('selectedPaymentInput').val() !== 'square') return

        // Prevent the form from submitting with the default action
        event.preventDefault()

        var tokenResult = await this.card.tokenize();
        this.onResponseReceived(tokenResult);
    }

    ProcessSquare.prototype.onResponseReceived = async function (tokenResult) {
        var self = this,
            $form = this.$checkoutForm,
            verificationDetails = {
                intent: 'CHARGE',
                amount: this.options.orderTotal.toString(),
                currencyCode: this.options.currencyCode,
                billingContact: {
                    givenName: $('input[name="first_name"]', this.$checkoutForm).val(),
                    familyName: $('input[name="last_name"]', this.$checkoutForm).val(),
                }
            }

        if (tokenResult.errors) {
            var $el = '<b>Encountered errors:</b>';
            tokenResult.errors.forEach(function (error) {
                $el += '<div>'+error.message+'</div>'
            });
            $form.find(this.options.errorSelector).html($el);
            return;
        }

        var verificationToken = await this.verifyBuyerHelper(tokenResult, verificationDetails);

        $form.find('input[name="square_card_nonce"]').val(tokenResult.token);
        $form.find('input[name="square_card_token"]').val(verificationToken);

        // Switch back to default to submit form
        $form.unbind('submitCheckoutForm').submit()
    }

    ProcessSquare.prototype.verifyBuyerHelper = async function (paymentToken, verificationDetails) {

        var verificationResults = await this.payments.verifyBuyer(
            paymentToken.token,
            verificationDetails
        );
        return verificationResults.token;
    }

    ProcessSquare.DEFAULTS = {
        applicationId: undefined,
        locationId: undefined,
        orderTotal: undefined,
        currencyCode: undefined,
        cardSelector: '#square-card-element',
        errorSelector: '#square-card-errors',
        cardFormStyle: {
            input: {
                backgroundColor: '#FFF',
                color: '#000000',
                fontSize: '16px'
            },
            'input::placeholder': {
                color: '#A5A5A5',
            },
            '.message-icon': {
                color: '#A5A5A5',
            }
        }
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.processSquare

    $.fn.processSquare = function (option) {
        var $this = $(this).first()
        var options = $.extend(true, {}, ProcessSquare.DEFAULTS, $this.data(), typeof option == 'object' && option)

        return new ProcessSquare($this, options)
    }

    $.fn.processSquare.Constructor = ProcessSquare

    $.fn.processSquare.noConflict = function () {
        $.fn.processSquare = old
        return this
    }

    $(document).render(function () {
        $('#squarePaymentForm').processSquare()
    })
}(window.jQuery)
