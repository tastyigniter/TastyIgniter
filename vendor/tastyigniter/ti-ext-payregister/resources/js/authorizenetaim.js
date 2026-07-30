+function ($) {
    "use strict"

    window.authorizeNetAimResponseHandler = function (response) {
        var event = jQuery.Event('handleAuthorizeNetAimResponse');
        jQuery(window).trigger(event, response);
    }

    var AuthorizeNetAim = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.$checkoutForm = this.$el.closest('[data-control="checkout"]')

        this.init()
    }

    AuthorizeNetAim.prototype.init = function () {
        if (this.$checkoutForm.checkout('selectedPaymentInput').val() !== 'authorizenetaim') return

        this.$acceptButton = this.$checkoutForm.find(this.options.btnSelector)

        if (this.$acceptButton.length < 1) return

        if (this.$acceptButton.attr('data-clientKey').length < 1
            || this.$acceptButton.attr('data-apiLoginID').length < 1
        ) throw new Error('Missing Authorize.Net client key or API Login ID')

        var self = this
        this.loadScripts().done(function () {
            self.$checkoutForm.on('submitCheckoutForm', $.proxy(self.showForm, self))
            $(window).on('handleAuthorizeNetAimResponse', $.proxy(self.responseHandler, self))

            self.acceptJsLoaded = true;
        })
    }

    AuthorizeNetAim.prototype.loadScripts = function () {
        return $.when(
            $.getScript(this.options.acceptJsEndpoint+'/v1/Accept.js'),
            $.getScript(this.options.acceptJsEndpoint+'/v3/AcceptUI.js')
        );
    }

    AuthorizeNetAim.prototype.showForm = function (event) {
        console.log(this.$checkoutForm.checkout('selectedPaymentInput').val())
        if (this.$checkoutForm.checkout('selectedPaymentInput').val() !== 'authorizenetaim') return

        // Prevent the form from submitting with the default action
        event.preventDefault()

        $("#AcceptUIContainer").addClass('show');
        $("#AcceptUIBackground").addClass('show');
    }

    AuthorizeNetAim.prototype.hideForm = function () {
        $("#AcceptUIContainer").addClass('show');
        $("#AcceptUIBackground").addClass('show');
    }

    AuthorizeNetAim.prototype.responseHandler = function (event, response) {
        var $form = this.$checkoutForm,
            $errorSelector = $form.find(this.options.errorSelector)

        console.log(this.$checkoutForm.checkout('selectedPaymentInput').val())
        if (this.$checkoutForm.checkout('selectedPaymentInput').val() !== 'authorizenetaim') return

        if (response.messages.resultCode === "Error") {
            var i = 0;
            while (i < response.messages.message.length) {
                $errorSelector.html(response.messages.message[i].code+": "+
                    response.messages.message[i].text)
                i = i+1;
            }

            this.hideForm()
        } else {
            $form.find('input[name="authorizenetaim_DataDescriptor"]').val(response.opaqueData.dataDescriptor)
            $form.find('input[name="authorizenetaim_DataValue"]').val(response.opaqueData.dataValue)

            // Switch back to default to submit form
            $form.unbind('submitCheckoutForm').submit()
        }
    }

    AuthorizeNetAim.DEFAULTS = {
        acceptJsEndpoint: undefined,
        btnSelector: '.AcceptUI',
        errorSelector: '#authorizenetaim-errors',
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.authorizeNetAim

    $.fn.authorizeNetAim = function (option) {
        var $this = $(this).first()
        var options = $.extend(true, {}, AuthorizeNetAim.DEFAULTS, $this.data(), typeof option == 'object' && option)

        return new AuthorizeNetAim($this, options)
    }

    $.fn.authorizeNetAim.Constructor = AuthorizeNetAim

    $.fn.authorizeNetAim.noConflict = function () {
        $.fn.booking = old
        return this
    }

    $(document).render(function () {
        $('#authorizeNetAimPaymentForm').authorizeNetAim()
    })
}(window.jQuery)
