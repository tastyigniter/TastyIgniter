+function ($) {
    "use strict";

    // FIELD MENU OPTION EDITOR CLASS DEFINITION
    // ============================

    var MenuOptionEditor = function (element, options) {
        this.options = options
        this.$el = $(element)

        // Init
        this.init()
    }

    MenuOptionEditor.DEFAULTS = {
        alias: undefined,
    }

    MenuOptionEditor.prototype.init = function () {
        this.$el.on('click', '[data-control="assign-item"]', $.proxy(this.onAssignItem, this))
        this.$el.on('click', '[data-control="load-item"]', $.proxy(this.onLoadItem, this))
        this.$el.on('click', '[data-control="delete-item"]', $.proxy(this.onDeleteItem, this))
    }

    MenuOptionEditor.prototype.unbind = function () {
        this.$el.removeData('ti.menuOptionEditor')
        this.$el = null
    }

    // EVENT HANDLERS
    // ============================

    MenuOptionEditor.prototype.onAssignItem = function (event) {
        var handler = this.options.alias+'::onAssignRecord',
            $button = $(event.currentTarget)

        $.request(handler, {
            data: {optionId: $('[data-control="choose-item"]').val()},
        })
    }

    MenuOptionEditor.prototype.onLoadItem = function (event) {
        var $button = $(event.currentTarget)

        new $.ti.recordEditor.modal({
            alias: this.options.alias,
            recordId: $button.data('itemId'),
            onSave: function () {
                this.hide()
            }
        })
    }

    MenuOptionEditor.prototype.onDeleteItem = function (event) {
        var handler = this.options.alias+'::onDeleteRecord',
            $button = $(event.currentTarget),
            itemSelector = $button.data('itemSelector'),
            confirmMsg = $button.data('confirmMessage')

        $.request(handler, {
            data: {
                recordId: $button.data('itemId'),
            },
            confirm: confirmMsg,
        }).done(function () {
            $button.closest(itemSelector).remove()
        })
    }

    // FIELD MENU OPTION EDITOR PLUGIN DEFINITION
    // ============================

    var old = $.fn.menuOptionEditor

    $.fn.menuOptionEditor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.menuOptionEditor')
            var options = $.extend({}, MenuOptionEditor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.menuOptionEditor', (data = new MenuOptionEditor(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.menuOptionEditor.Constructor = MenuOptionEditor

    // FIELD MENU OPTION EDITOR NO CONFLICT
    // =================

    $.fn.menuOptionEditor.noConflict = function () {
        $.fn.menuOptionEditor = old
        return this
    }

    // FIELD MENU OPTION EDITOR DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="menu-option-editor"]', document).menuOptionEditor()
    });

}(window.jQuery);
