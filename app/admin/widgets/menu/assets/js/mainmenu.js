+function ($) {
    "use strict";

    // MAINMENU CLASS DEFINITION
    // ============================

    var MainMenu = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.$refreshButton = $('<button type="button" class="btn btn-default pull-right refresh"><i class="fa fa-refresh"></i></button>')

        // Init
        this.init()
    }

    MainMenu.prototype.init = function () {
        if (this.options.alias === undefined)
            throw new Error('Main menu option "alias" is not set.')

        this.$el.on('show.bs.dropdown', '.dropdown', $.proxy(this.onDropdownShow, this))
    }

    MainMenu.prototype.requestOptions = function ($itemMenu) {
        var self = this,
            itemName = $itemMenu.data('requestOptions')

        if ($itemMenu.hasClass('is-loaded'))
            return

        $.request(this.options.alias + '::onGetDropdownOptions', {
            type: 'GET',
            data: {item: itemName}
        }).always(function () {
            var $refreshButton = self.$refreshButton.clone()
            $itemMenu.find('.menu-header .refresh').remove()
            $itemMenu.find('.menu-header').prepend($refreshButton)
            $refreshButton.on('click', $.proxy(self.onRefreshOptions, self))
        }).done(function () {
            $itemMenu.addClass('is-loaded')
        })
    }

    // EVENT HANDLERS
    // ============================

    MainMenu.prototype.onDropdownShow = function (event) {
        var $toggle = $(event.relatedTarget),
            $dropdown = $toggle.closest('.dropdown'),
            $itemMenu = $dropdown.find('[data-request-options]')

        if (!$itemMenu.length)
            return;

        this.requestOptions($itemMenu)
    }

    MainMenu.prototype.onRefreshOptions = function (event) {
        var $toggle = $(event.target),
            $dropdown = $toggle.closest('.dropdown'),
            $itemMenu = $dropdown.find('[data-request-options]')

        if (!$itemMenu.length)
            return;

        $itemMenu.removeClass('is-loaded')

        this.requestOptions($itemMenu)
    }

    MainMenu.DEFAULTS = {
        alias: undefined,
    }

    // FIELD MainMenu PLUGIN DEFINITION
    // ============================

    var old = $.fn.mainMenu

    $.fn.mainMenu = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.mainMenu')
            var options = $.extend({}, MainMenu.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.mainMenu', (data = new MainMenu(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.mainMenu.Constructor = MainMenu

    // FIELD MainMenu NO CONFLICT
    // =================

    $.fn.mainMenu.noConflict = function () {
        $.fn.mainMenu = old
        return this
    }

    // FIELD MainMenu DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="mainmenu"]').mainMenu()
    });

}(window.jQuery);