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
        keyFromName: 'option_id',
        sortableHandle: '.connector-item-handle',
        sortableContainer: 'ul.field-connector-items'
    }

    Connector.prototype.init = function () {
        this.$el.on('change', 'select[data-control="add-item"]', $.proxy(this.onChooseOption, this))
        this.$el.on('click', '[data-control="remove-item"]', $.proxy(this.onChooseOption, this))

        this.bindSorting()
    }

    Connector.prototype.bindSorting = function () {
        var sortableOptions = {
            handle: this.options.sortableHandle,
            itemSelector: '.panel',
            placeholder: '<div class="placeholder"></div>'
        }

        this.$sortable.sortable(sortableOptions)
    }

    Connector.prototype.unbind = function () {
        this.$sortable.sortable('destroy')
        this.$el.removeData('ti.connector')
    }

    // EVENT HANDLERS
    // ============================

    Connector.prototype.onChooseOption = function (event) {
        var self = this,
            keyFromName = self.options.keyFromName,
            $element = $(event.target),
            $itemGroup = self.$el.find('.panel-group'),
            $lastAddedItem = $itemGroup.find('.panel:last-child'),
            lastIndex = $lastAddedItem.data('itemIndex'),
            requestData = {indexValue: lastIndex}

        requestData[keyFromName] = $element.val()

        $.ti.loadingIndicator.show()
        $element.request($element.data('handler'), {
            data: requestData
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

    $(document).ready(function () {
        $('[data-control="connector"]').connector()
    });

}(window.jQuery);