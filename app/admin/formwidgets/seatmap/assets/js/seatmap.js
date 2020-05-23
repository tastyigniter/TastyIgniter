+function ($) {
    "use strict";

    var SeatMap = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.$sortable = $(options.sortableContainer, this.$el)

        this.init()
    }

    SeatMap.prototype.init = function () {
        this.$el.on('click', '[data-control="delete-item"]', $.proxy(this.onDeleteItem, this))

        this.bindSorting()
    }

    SeatMap.prototype.bindSorting = function () {
        var sortableOptions = {
            handle: this.options.sortableHandle,
            itemSelector: this.options.sortableItemSelector,
            placeholder: this.options.sortablePlaceholder
        }

        this.$el.each(function () {
            $.each(this.attributes, function () {
                if(this.specified && this.name.match("^data-sortable-")) {
                    var name = this.name.replace('data-sortable-', '')
                    sortableOptions[name] = this.value
                }
            })
        })

        this.$sortable.sortable(sortableOptions)
    }

    SeatMap.prototype.unbind = function () {
        this.$sortable.sortable('destroy')
        this.$el.removeData('ti.seatmap')
        this.$el = null
    }

    // EVENT HANDLERS
    // ============================

    SeatMap.prototype.onDeleteItem = function (event) {
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

    // HELPER METHODS
    // ============================

    SeatMap.DEFAULTS = {
        alias: undefined,
        sortableHandle: '.seatmap-item-handle',
        sortableContainer: '.field-seatmap-items',
        sortableItemSelector: '.card',
        sortablePlaceholder: '<div class="placeholder seatmap-placeholder"></div>'
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.seatMap

    $.fn.seatMap = function (option) {
        var args = arguments;

        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.seatMap')
            var options = $.extend({}, SeatMap.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.seatMap', (data = new SeatMap(this, options)))
            if (typeof option == 'string') data[option].apply(data, args)
        })
    }

    $.fn.seatMap.Constructor = SeatMap

    $.fn.seatMap.noConflict = function () {
        $.fn.seatMap = old
        return this
    }

    $(document).render(function () {
        $('[data-control="seat-map"]').seatMap();
    })

}(window.jQuery);