/*
 * Table plugin
 *
 * Data attributes:
 * - data-control="table" - enables the plugin on an element
 */
+function ($) {
    "use strict";

    // FIELD TABLE CLASS DEFINITION
    // ============================

    var Table = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.table = null

        // Init
        this.init()
    }

    Table.DEFAULTS = {
        columns: [],
        data: [],
        classes: 'table table-striped',
        iconsPrefix: 'fa'
    }

    Table.prototype.init = function () {
        this.$table = $('<table/>', {
            id: this.$el.attr('id') + '-table',
        })

        this.$el.append(this.$table)
        this.table = this.$table.bootstrapTable(this.options)
    }

    // FIELD Table PLUGIN DEFINITION
    // ============================

    var old = $.fn.table

    $.fn.table = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.table')
            var options = $.extend({}, Table.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.table', (data = new Table(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.table.Constructor = Table

    // FIELD Table NO CONFLICT
    // =================

    $.fn.table.noConflict = function () {
        $.fn.table = old
        return this
    }

    // FIELD Table DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="table"]').table()
    });

}(window.jQuery);
