/* ========================================================================
 * TastyIgniter: checkout.js v2.2.0
 * https://tastyigniter.com/docs/javascript
 * ======================================================================== */
+function ($) {
    "use strict"

    var Checkout = function (options, el) {
    }

    Checkout.DEFAULTS = {
        container: '#notification',
        class: 'success',
        text: 'text',
        interval: 5
    }

    // FLASH MESSAGE PLUGIN DEFINITION
    // ============================

    if ($.ti === undefined)
        $.ti = {}

    $.ti.checkout = Checkout

    // FLASH MESSAGE DATA-API
    // ===============

    $(document).ready(function () {
       $(document).on('click', '[data-control="submit-checkout"]', function () {
            $('#checkout-form').submit()
        })
    })

}(window.jQuery)
