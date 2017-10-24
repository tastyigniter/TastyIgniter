+function ($) {
    "use strict";

    // FIELD MENUOPTIONEDITOR CLASS DEFINITION
    // ============================

    var Connector = function(element, options) {
        this.options   = options
        this.$el       = $(element)
        this.$sortable = $(options.sortableContainer, this.$el)

        // Init
        this.init()
    }

    Connector.DEFAULTS = {
        sortableHandle: '.connector-item-handle',
        sortableContainer: 'ul.field-connector-items'
    }

    Connector.prototype.init = function() {
        this.$el.on('change', 'select[data-control="add-item"]', $.proxy(this.onChooseOption, this))

        this.bindSorting()
    }

    Connector.prototype.bindSorting = function() {
        var sortableOptions = {
            handle: this.options.sortableHandle,
            itemSelector: '.panel',
            placeholder: '<div class="placeholder"></div>'
        }

        this.$sortable.sortable(sortableOptions)
    }

    Connector.prototype.unbind = function() {
        this.$sortable.sortable('destroy')
        this.$el.removeData('ti.connector')
    }

    // EVENT HANDLERS
    // ============================

    Connector.prototype.onChooseOption = function(event) {
        var self = this,
            $element = $(event.target),
            $itemGroup = self.$el.find('.panel-group'),
            $lastAddedItem = $itemGroup.find('.panel:last-child'),
            lastIndex = $lastAddedItem.data('itemIndex'),
            value = $element.val()

        if (typeof lastIndex == 'undefined')
            lastIndex = '0'

        $.ti.loadingIndicator.show()
        $element.request($element.data('request'), {
            data: {option_id: value, indexValue: lastIndex}
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done(function () {
            $lastAddedItem = $itemGroup.find('.panel:last-child')
            $lastAddedItem.find('[data-toggle="toggle"]').bootstrapToggle();
            $lastAddedItem.find('[data-control="repeater"]').repeater()

        })
    }

    // FIELD CONNECTOR PLUGIN DEFINITION
    // ============================

    var old = $.fn.connector

    $.fn.connector = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this   = $(this)
            var data    = $this.data('ti.connector')
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

    $(document).ready(function() {
        $('[data-control="connector"]').connector()
    });

}(window.jQuery);