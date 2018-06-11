/* ========================================================================
 * TastyIgniter: flashmessage.js v2.2.0
 * https://tastyigniter.com/docs/javascript
 * ======================================================================== */
+function ($) {
    "use strict"

    var FlashMessage = function (options, el) {
        var options = $.extend({}, FlashMessage.DEFAULTS, options),
            $element = $(el)

        $('body > p.flash-message').remove()

        if ($element.length === 0) {
            $element = $('<div />', {
                class: 'animated bounceIn alert alert-' + options.class
            }).html(options.text)
        }

        $element.addClass('flash-message fade')
        $element.append('<button type="button" class="close" aria-hidden="true">&times;</button>')
        $element.attr('data-control', null)

        $element.on('click', 'button', remove)
        if (options.interval > 0) $element.on('click', remove)

        $(options.container).append($element)

        setTimeout(function () {
            $element.addClass('show')
        }, 100)

        var timer = null

        if (options.interval > 0)
            timer = window.setTimeout(remove, options.interval * 1000)

        function removeElement() {
            $element.remove()
        }

        function remove() {
            window.clearInterval(timer)

            $element.removeClass('show')
            $.support.transition && $element.hasClass('fade')
                ? $element
                .one($.support.transition.end, removeElement)
                .emulateTransitionEnd(500)
                : removeElement()
        }
    }

    FlashMessage.DEFAULTS = {
        container: '#notification',
        class: 'success',
        text: 'text',
        interval: 5
    }

    // FLASH MESSAGE PLUGIN DEFINITION
    // ============================

    if ($.ti === undefined)
        $.ti = {}

    $.ti.flashMessage = FlashMessage

    // FLASH MESSAGE DATA-API
    // ===============

    $(document).ready(function () {
        $('[data-control="flash-message"]').each(function () {
            $.ti.flashMessage($(this).data(), this)
        })
    })

}(window.jQuery)
