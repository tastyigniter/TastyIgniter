+function ($) {
    "use strict";

    var PaymentAttempts = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.editorModal = null

        this.init()
    }

    PaymentAttempts.prototype.constructor = PaymentAttempts

    PaymentAttempts.prototype.dispose = function () {
        this.editorModal.remove()
        this.editorModal = null
    }

    PaymentAttempts.prototype.init = function () {
        this.$el.on('click', '[data-control="refund"]', $.proxy(this.loadRecordForm, this))
    }

    PaymentAttempts.prototype.loadRecordForm = function (event) {
        var $button = $(event.currentTarget)

        new $.ti.recordEditor.modal({
            alias: this.options.alias,
            recordId: $button.data('logId'),
            onSave: function () {
                this.hide()
            },
            onLoad: function () {
            }
        })
    }

    // EVENT HANDLERS
    // ============================

    PaymentAttempts.prototype.onControlClick = function (event) {
        this.loadRecordForm(event)
    }

    PaymentAttempts.DEFAULTS = {
        alias: undefined
    }

    // FormTable PLUGIN DEFINITION
    // ============================

    var old = $.fn.paymentAttempts

    $.fn.paymentAttempts = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.paymentAttempts')
            var options = $.extend({}, PaymentAttempts.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.paymentAttempts', (data = new PaymentAttempts(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.paymentAttempts.Constructor = PaymentAttempts

    // PaymentAttempts NO CONFLICT
    // =================

    $.fn.paymentAttempts.noConflict = function () {
        $.fn.paymentAttempts = old
        return this
    }

    // PaymentAttempts DATA-API
    // ===============
    $(document).render(function () {
        $('[data-control="payment-attempts"]').paymentAttempts()
    })
}(window.jQuery);
