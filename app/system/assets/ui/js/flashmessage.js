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
                class: 'alert alert-' + options.class
            }).html(options.text)
        }

        $element.addClass('flash-message animated fadeInDown')
        $element.attr('data-control', null)

        if (options.allowDismiss)
            $element.append('<button type="button" class="close" aria-hidden="true">&times;</button>')

        $element.on('click', 'button', remove)
        if (options.interval > 0) $element.on('click', remove)

        $(options.container).prepend($element)

        var timer = null

        setTimeout(function () {
            $element.addClass('show')
        }, 100)

        if (options.allowDismiss && options.interval > 0)
            timer = window.setTimeout(remove, options.interval * 1000)

        function removeElement() {
            $element.remove()
        }

        function remove() {
            window.clearInterval(timer)

            $element.addClass('fadeOutUp')
            $.support.transition && $element.hasClass('fadeOutUp')
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
        interval: 5,
        allowDismiss: true,
    }

    // FLASH MESSAGE PLUGIN DEFINITION
    // ============================

    if ($.ti === undefined)
        $.ti = {}

    $.ti.flashMessage = FlashMessage

    // FLASH MESSAGE DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="flash-message"]').each(function (index, element) {
            setTimeout(function () {
                $.ti.flashMessage($(element).data(), element)
            }, (index + 1) * 500)
        })

        $('[data-control="flash-overlay"]').each(function (index, element) {
            var $this = $(element),
                options = $.extend({}, $this.data(), $this.data('closeOnEsc') === true ? {
                timer: (index + 1) * 3000
            } : {})
            swal(options)
        })
    })

}(window.jQuery)
