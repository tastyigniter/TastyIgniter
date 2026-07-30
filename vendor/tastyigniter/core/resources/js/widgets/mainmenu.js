+function ($) {
    "use strict";

    // MAINMENU CLASS DEFINITION
    // ============================

    var MainMenu = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.loadingHtml = '<span class="ti-loading spinner-border text-muted fa-3x fa-fw"></span>'

        // Init
        this.init()
    }

    MainMenu.prototype.init = function () {
        if (this.options.alias === undefined)
            throw new Error('Main menu option "alias" is not set.')

        this.$el.on('show.bs.dropdown', '.dropdown', $.proxy(this.onDropdownShow, this))
    }

    MainMenu.prototype.requestOptions = function ($itemMenu) {
        var itemName = $itemMenu.data('mainmenu-item'),
            requestHandler = $itemMenu.data('mainmenu-item-handler')
                ? $itemMenu.data('mainmenu-item-handler')
                : this.options.alias+'::onGetDropdownOptions'

        if ($itemMenu.hasClass('is-loaded'))
            return

        $.request(requestHandler, {
            type: 'GET',
            data: {item: itemName}
        }).done(function () {
            $itemMenu.addClass('is-loaded')
        })
    }

    MainMenu.prototype.clearOptions = function (itemName) {
        var $itemMenu = this.$el.find('[data-mainmenu-item='+itemName+']')

        if (!$itemMenu.length || !$itemMenu.hasClass('is-loaded'))
            return

        $itemMenu.dropdown('hide')
        $itemMenu.removeClass('is-loaded')
        $itemMenu.find('.dropdown-body').html(this.loadingHtml)
    }

    MainMenu.prototype.updateBadgeCount = function (itemName, count) {
        var $itemMenu = this.$el.find('[data-mainmenu-item='+itemName+']'),
            $dropdownBadge = $itemMenu.find('[data-bs-toggle="dropdown"] .badge')

        $dropdownBadge.removeClass('hide');
    }

    // EVENT HANDLERS
    // ============================

    MainMenu.prototype.onDropdownShow = function (event) {
        var $toggle = $(event.relatedTarget),
            $itemMenu = $toggle.closest('[data-mainmenu-item]')

        if (window.matchMedia('(max-width: 600px)'))
            $('.sidebar, .nav-sidebar').collapse('hide')

        if (!$itemMenu.length)
            return;

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
