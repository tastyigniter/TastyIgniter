+function ($) {
    "use strict";

    // FIELD MENUOPTIONEDITOR CLASS DEFINITION
    // ============================

    var Connector = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.$sortable = $(options.sortableContainer, this.$el)

        // Init
        this.init()
    }

    Connector.DEFAULTS = {
        alias: undefined,
        sortableHandle: '.connector-item-handle',
        sortableContainer: '.field-connector-items'
    }

    Connector.prototype.init = function () {
        this.$el.on('click', '[data-control="load-item"]', $.proxy(this.onLoadItem, this))
        this.$el.on('click', '[data-control="delete-item"]', $.proxy(this.onDeleteItem, this))

        this.bindSorting()
    }

    Connector.prototype.bindSorting = function () {
        var sortableOptions = {
            handle: this.options.sortableHandle,
            itemSelector: '.card',
            placeholder: '<div class="placeholder sortable-placeholder"></div>'
        }

        this.$sortable.sortable(sortableOptions)
    }

    Connector.prototype.unbind = function () {
        this.$sortable.sortable('destroy')
        this.$el.removeData('ti.connector')
        this.$el = null
    }

    // EVENT HANDLERS
    // ============================

    Connector.prototype.onLoadItem = function (event) {
        var $button = $(event.currentTarget)

        new $.ti.recordEditor.modal({
            alias: this.options.alias,
            recordId: $button.data('itemId'),
            onSave: function () {
                this.hide()
            }
        })
    }

    Connector.prototype.onDeleteItem = function (event) {
        var handler = this.options.alias + '::onDeleteRecord',
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

    // FIELD CONNECTOR PLUGIN DEFINITION
    // ============================

    var old = $.fn.connector

    $.fn.connector = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.connector')
            var options = $.extend({}, Connector.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.connector', (data = new Connector(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.connector.Constructor = Connector

    // FIELD CONNECTOR NO CONFLICT
    // =================

    $.fn.connector.noConflict = function () {
        $.fn.connector = old
        return this
    }

    // FIELD CONNECTOR DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="connector"]', document).connector()
    });

}(window.jQuery);