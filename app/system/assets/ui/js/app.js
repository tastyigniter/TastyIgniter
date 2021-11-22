/*
 * Custom event that unifies document.ready with window.ajaxUpdateComplete
 *
 * $(document).render(function() { })
 * $(document).on('render', function() { })
 */
+function ($) {
    "use strict";

    $(document).ready(function () {
        $(document).trigger('render')
    })

    $(window).on('ajaxUpdateComplete', function () {
        $(document).trigger('render')
    })

    $.fn.render = function (callback) {
        $(document).on('render', callback)
    }
}(window.jQuery);
