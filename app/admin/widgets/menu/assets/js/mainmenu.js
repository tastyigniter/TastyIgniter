+function ($) {
    "use strict";

    // MAINMENU CLASS DEFINITION
    // ============================

    var MainMenu = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.loadingHtml = '<span class="ti-loading spinner-border text-muted fa-3x fa-fw"></span>'
        this.$markAsReadButton = $('<a href="#" class="pull-right mark-as-read"><i class="fa fa-check"></i></a>')

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
        }).done(function () {
            var $markAsReadButton = self.$markAsReadButton.clone()
            $itemMenu.find('.dropdown-header .mark-as-read').remove()
            $itemMenu.find('.dropdown-header').prepend($markAsReadButton)
            $markAsReadButton.on('click', $.proxy(self.onMarkOptionsAsRead, self))

            $itemMenu.addClass('is-loaded')
        })
    }

    MainMenu.prototype.clearOptions = function (itemName) {
        var $itemMenu = this.$el.find('[data-request-options='+itemName+']')

        if (!$itemMenu.length || !$itemMenu.hasClass('is-loaded'))
            return

        $itemMenu.dropdown('hide')
        $itemMenu.removeClass('is-loaded')
        $itemMenu.find('.dropdown-header .mark-as-read').remove()
        $itemMenu.find('.dropdown-body').html(this.loadingHtml)
    }

    MainMenu.prototype.updateBadgeCount = function (itemName, count) {
        var $itemMenu = this.$el.find('[data-request-options='+itemName+']'),
            $dropdown = $itemMenu.closest('.dropdown'),
            $dropdownBadge = $dropdown.find('[data-bs-toggle="dropdown"] .badge'),
            prevBadgeCount = parseInt($dropdownBadge.html()),
            badgeCount = (isNaN(prevBadgeCount) ? 0 : prevBadgeCount)+parseInt(count)

        $dropdownBadge.html(badgeCount < 100 ? badgeCount : '+99')
    }

    // EVENT HANDLERS
    // ============================

    MainMenu.prototype.onDropdownShow = function (event) {
        var $toggle = $(event.relatedTarget),
            $dropdown = $toggle.closest('.dropdown'),
            $itemMenu = $dropdown.find('[data-request-options]')

        if (window.matchMedia('(max-width: 600px)'))
            $('.sidebar, .nav-sidebar').collapse('hide')

        if (!$itemMenu.length)
            return;

        this.requestOptions($itemMenu)
    }

    MainMenu.prototype.onMarkOptionsAsRead = function (event) {
        var $toggle = $(event.target),
            $dropdown = $toggle.closest('.dropdown'),
            $itemMenu = $dropdown.find('[data-request-options]'),
            $dropdownBadge = $dropdown.find('[data-bs-toggle="dropdown"] .badge'),
            itemName = $itemMenu.data('requestOptions')

        if (!$itemMenu.length)
            return;

        $.request(this.options.alias + '::onMarkOptionsAsRead', {
            data: {item: itemName}
        }).done(function () {
            $dropdownBadge.empty()
            $itemMenu.find('.menu-item.active').removeClass('active')
        })
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
