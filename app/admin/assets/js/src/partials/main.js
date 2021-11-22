/**
 * Load required plugins.
 */
try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('@popperjs/core');

    window.bootstrap = require('bootstrap');
} catch (e) {
}

if (window.jQuery === undefined)
    throw new Error('TastyIgniter Javascript requires jQuery.');

if (window.jQuery.request !== undefined)
    throw new Error('The TastyIgniter Javascript framework is already loaded.');

/**
 * Create window.page and init the application.
 */

+(function ($, window) {
    var page = {
        name: 'TastyIgniter',

        body: $('body'),
        navbar: $("#side-nav-menu"),
        header: $('.site-header'),
        footer: $('.site-footer'),
    };

    /**
     * Call all the required initializers.
     */
    page.init = function () {
        page.initAlert();
        page.initNavbar();
        page.initSelect2();
        page.initTooltip();
    };

    window.page = page;

    $(document).ready(function () {
        $(document).trigger('render')
    })

    $(window).on('ajaxUpdateComplete', function () {
        $(document).trigger('render')
    })

    $.fn.render = function (callback) {
        $(document).on('render', callback)
    }

    /**
     * Once the DOM is loaded, start the magic.
     */
    $(document).render(function () {
        page.init();
    });
})(jQuery, window);
